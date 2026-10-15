<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateSalaryRequest;
use App\Models\SalaryHistory;
use App\Services\SalaryCalculator;
use Illuminate\View\View;

class SalaryController extends Controller
{
    public function create(): View
    {
        return view('salaries.create');
    }

    public function calculate(
        CalculateSalaryRequest $request,
        SalaryCalculator $calculator
    ): View {
        $salary = (float) $request->validated('salary');
        $frequency = $request->validated('frequency') ?? 'mensual';

        $result = $calculator->calculate($salary, $frequency);

        SalaryHistory::create($result->toArray());

        return view('salaries.create', [
            'salary' => $salary,
            'frequency' => $frequency,
            'result' => $result,
        ]);
    }
}