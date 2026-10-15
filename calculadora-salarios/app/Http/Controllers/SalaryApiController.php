<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateSalaryRequest;
use App\Services\SalaryCalculator;
use Illuminate\Http\JsonResponse;

class SalaryApiController extends Controller
{
    public function calculate(
        CalculateSalaryRequest $request,
        SalaryCalculator $calculator
    ): JsonResponse {
        $salary = (float) $request->validated('salary');
        $frequency = $request->validated('frequency') ?? 'mensual';

        $calculation = $calculator->calculate($salary, $frequency);

        return response()->json([
            'data' => $calculation,
            'effective_from' => config('payroll.effective_from'),
        ]);
    }
}