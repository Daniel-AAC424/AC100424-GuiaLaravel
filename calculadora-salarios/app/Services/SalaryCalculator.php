<?php

namespace App\Services;

use App\DataTransferObjects\SalaryCalculation;

final class SalaryCalculator
{
    public function calculate(float $monthlyGross, string $frequency = 'mensual'): SalaryCalculation
    {
        $config = config("payroll.frequencies.$frequency");

        $gross = $this->roundMoney($monthlyGross / $config['payments_per_month']);

        $isssBase = min($gross, (float) $config['isss_ceiling']);

        $employeeIsss = $this->roundMoney($isssBase * config('payroll.isss_employee_rate'));
        $employeeAfp = $this->roundMoney($gross * config('payroll.afp_employee_rate'));

        $taxableBase = $this->roundMoney(max(0, $gross - $employeeIsss - $employeeAfp));

        $incomeTax = $this->calculateIncomeTax($taxableBase, $config['isr']);

        $netSalary = $this->roundMoney($gross - $employeeIsss - $employeeAfp - $incomeTax);

        $employerIsss = $this->roundMoney($isssBase * config('payroll.isss_employer_rate'));
        $employerAfp = $this->roundMoney($gross * config('payroll.afp_employer_rate'));
        $employerCost = $this->roundMoney($gross + $employerIsss + $employerAfp);

        return new SalaryCalculation(
            frequency: $frequency,
            grossSalary: $gross,
            employeeIsss: $employeeIsss,
            employeeAfp: $employeeAfp,
            taxableBase: $taxableBase,
            incomeTax: $incomeTax,
            netSalary: $netSalary,
            employerIsss: $employerIsss,
            employerAfp: $employerAfp,
            employerCost: $employerCost,
        );
    }

    private function calculateIncomeTax(float $base, array $rules): float
    {
        if ($base <= $rules['exempt_limit']) {
            return 0.00;
        }

        if ($base <= $rules['second_limit']) {
            return $this->roundMoney(
                $rules['second_fixed'] + (($base - $rules['exempt_limit']) * 0.10)
            );
        }

        if ($base <= $rules['third_limit']) {
            return $this->roundMoney(
                $rules['third_fixed'] + (($base - $rules['second_limit']) * 0.20)
            );
        }

        return $this->roundMoney(
            $rules['fourth_fixed'] + (($base - $rules['third_limit']) * 0.30)
        );
    }

    private function roundMoney(float $value): float
    {
        return round(round($value, 10), 2);
    }
}