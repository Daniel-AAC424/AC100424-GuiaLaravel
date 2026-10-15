<?php

namespace Tests\Feature;

use Tests\TestCase;

class SalaryApiTest extends TestCase
{
    public function test_api_returns_json_calculation_for_default_frequency(): void
    {
        $this->postJson(route('api.salaries.calculate'), [
            'salary' => 1500,
        ])
            ->assertOk()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonPath('data.frequency', 'mensual')
            ->assertJsonPath('data.gross_salary', 1500)
            ->assertJsonPath('data.employee_isss', 30)
            ->assertJsonPath('data.employee_afp', 108.75)
            ->assertJsonPath('data.taxable_base', 1361.25)
            ->assertJsonPath('data.income_tax', 153.20)
            ->assertJsonPath('data.net_salary', 1208.05)
            ->assertJsonPath('data.employer_isss', 75)
            ->assertJsonPath('data.employer_afp', 131.25)
            ->assertJsonPath('data.employer_cost', 1706.25);
    }

    public function test_api_calculates_a_quincenal_salary(): void
    {
        $this->postJson(route('api.salaries.calculate'), [
            'salary' => 1500,
            'frequency' => 'quincenal',
        ])
            ->assertOk()
            ->assertJsonPath('data.frequency', 'quincenal')
            ->assertJsonPath('data.gross_salary', 750)
            ->assertJsonPath('data.employee_isss', 15)
            ->assertJsonPath('data.employee_afp', 54.38)
            ->assertJsonPath('data.taxable_base', 680.62)
            ->assertJsonPath('data.income_tax', 76.60)
            ->assertJsonPath('data.net_salary', 604.02);
    }

    public function test_api_calculates_a_semanal_salary(): void
    {
        $this->postJson(route('api.salaries.calculate'), [
            'salary' => 1500,
            'frequency' => 'semanal',
        ])
            ->assertOk()
            ->assertJsonPath('data.frequency', 'semanal')
            ->assertJsonPath('data.gross_salary', 375)
            ->assertJsonPath('data.employee_isss', 7.50)
            ->assertJsonPath('data.employee_afp', 27.19)
            ->assertJsonPath('data.taxable_base', 340.31)
            ->assertJsonPath('data.income_tax', 38.30)
            ->assertJsonPath('data.net_salary', 302.01);
    }

    public function test_api_includes_rates_effective_date(): void
    {
        $this->postJson(route('api.salaries.calculate'), ['salary' => 1500])
            ->assertOk()
            ->assertJsonPath('effective_from', '2025-04-30');
    }

    public function test_api_returns_the_dto_structure_in_snake_case(): void
    {
        $this->postJson(route('api.salaries.calculate'), ['salary' => 800])
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'frequency',
                    'gross_salary',
                    'employee_isss',
                    'employee_afp',
                    'taxable_base',
                    'income_tax',
                    'net_salary',
                    'employer_isss',
                    'employer_afp',
                    'employer_cost',
                ],
                'effective_from',
            ]);
    }

    public function test_api_validates_salary_is_required(): void
    {
        $this->postJson(route('api.salaries.calculate'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors('salary');
    }

    public function test_api_validates_salary_bounds(): void
    {
        $this->postJson(route('api.salaries.calculate'), ['salary' => 0])
            ->assertStatus(422)
            ->assertJsonValidationErrors('salary');
    }

    public function test_api_rejects_an_invalid_frequency(): void
    {
        $this->postJson(route('api.salaries.calculate'), [
            'salary' => 1500,
            'frequency' => 'diario',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors('frequency');
    }
}