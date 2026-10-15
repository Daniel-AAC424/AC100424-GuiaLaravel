<?php

namespace App\DataTransferObjects;

use JsonSerializable;

final readonly class SalaryCalculation implements JsonSerializable
{
    public function __construct(
        public string $frequency,
        public float $grossSalary,
        public float $employeeIsss,
        public float $employeeAfp,
        public float $taxableBase,
        public float $incomeTax,
        public float $netSalary,
        public float $employerIsss,
        public float $employerAfp,
        public float $employerCost,
    ) {}

    /**
     * Mantiene las claves snake_case para persistencia y respuestas JSON.
     */
    public function toArray(): array
    {
        return [
            'frequency' => $this->frequency,
            'gross_salary' => $this->grossSalary,
            'employee_isss' => $this->employeeIsss,
            'employee_afp' => $this->employeeAfp,
            'taxable_base' => $this->taxableBase,
            'income_tax' => $this->incomeTax,
            'net_salary' => $this->netSalary,
            'employer_isss' => $this->employerIsss,
            'employer_afp' => $this->employerAfp,
            'employer_cost' => $this->employerCost,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}