<?php

namespace Tests\Feature;

use App\Services\SalaryCalculator;
use Tests\TestCase;

class SalaryCalculatorTest extends TestCase
{
    public function test_it_calculates_a_monthly_salary(): void
    {
        $result = app(SalaryCalculator::class)->calculate(1500.00);

        $this->assertSame(30.00, $result->employeeIsss);
        $this->assertSame(108.75, $result->employeeAfp);
        $this->assertSame(1361.25, $result->taxableBase);
        $this->assertSame(153.20, $result->incomeTax);
        $this->assertSame(1208.05, $result->netSalary);
        $this->assertSame(1706.25, $result->employerCost);
    }

    public function test_it_calculates_a_quincenal_salary(): void
    {
        $result = app(SalaryCalculator::class)->calculate(1500.00, 'quincenal');

        $this->assertSame(15.00, $result->employeeIsss);
        $this->assertSame(54.38, $result->employeeAfp);
        $this->assertSame(680.62, $result->taxableBase);
        $this->assertSame(76.60, $result->incomeTax);
        $this->assertSame(604.02, $result->netSalary);
    }

    public function test_it_calculates_a_semanal_salary(): void
    {
        $result = app(SalaryCalculator::class)->calculate(1500.00, 'semanal');

        $this->assertSame(7.50, $result->employeeIsss);
        $this->assertSame(27.19, $result->employeeAfp);
        $this->assertSame(340.31, $result->taxableBase);
        $this->assertSame(38.30, $result->incomeTax);
        $this->assertSame(302.01, $result->netSalary);
    }
}