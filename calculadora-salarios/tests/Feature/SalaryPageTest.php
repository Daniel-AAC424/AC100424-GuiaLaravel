<?php

namespace Tests\Feature;

use Tests\TestCase;

class SalaryPageTest extends TestCase
{
    public function test_form_can_be_opened(): void
    {
        $this->get(route('salaries.create'))
            ->assertOk()
            ->assertSee('Calculadora de salario mensual');
    }

    public function test_salary_is_required(): void
    {
        $this->post(route('salaries.calculate'), [])
            ->assertSessionHasErrors('salary');
    }

    public function test_valid_salary_shows_result(): void
    {
        $this->post(route('salaries.calculate'), [
            'salary' => '1500.00',
        ])->assertOk()->assertSee('1,208.05');
    }
        public function test_page_shows_rates_effective_date(): void
    {
        $this->get(route('salaries.create'))
            ->assertOk()
            ->assertSee('Tasas vigentes desde');
    }

    public function test_valid_salary_shows_result_with_frequency(): void
    {
        $this->post(route('salaries.calculate'), [
            'salary' => '1500.00',
            'frequency' => 'quincenal',
        ])->assertOk()->assertSee('604.02');
    }
}
