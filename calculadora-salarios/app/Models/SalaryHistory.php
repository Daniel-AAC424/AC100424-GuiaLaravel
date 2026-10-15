<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
#[Fillable([
    'frequency',
    'gross_salary', 'employee_isss', 'employee_afp', 'taxable_base',
    'income_tax', 'net_salary', 'employer_isss', 'employer_afp', 'employer_cost',
])]
class SalaryHistory extends Model
{
    protected function casts(): array
    {
        return [
            'gross_salary' => 'decimal:2',
            'employee_isss' => 'decimal:2',
            'employee_afp' => 'decimal:2',
            'taxable_base' => 'decimal:2',
            'income_tax' => 'decimal:2',
            'net_salary' => 'decimal:2',
            'employer_isss' => 'decimal:2',
            'employer_afp' => 'decimal:2',
            'employer_cost' => 'decimal:2',
        ];
    }
}