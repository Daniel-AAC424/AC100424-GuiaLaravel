<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora salarial</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef3f8; padding: 2rem; }
        main { max-width: 720px; margin: auto; background: white; padding: 2rem; }
        form { display: grid; gap: .75rem; margin: 1.5rem 0; }
        input, select, button { padding: .8rem; font-size: 1rem; }
        button { color: white; background: #17365d; border: 0; }
        .error { color: #9b1c1c; }
        .vigencia { color: #556; font-size: .9rem; }
        dl div { display: flex; justify-content: space-between; padding: .6rem 0; }
        dd { margin: 0; }
        .total { font-weight: bold; color: #17365d; }
    </style>
</head>
<body>
<main>
    <h1>Calculadora de salario mensual</h1>
    <p>Estimación educativa para El Salvador.</p>
    <p class="vigencia">
        Tasas vigentes desde:
        {{ \Illuminate\Support\Carbon::parse(config('payroll.effective_from'))->format('d/m/Y') }}
    </p>

    <form method="POST" action="{{ route('salaries.calculate') }}">
        @csrf
        <label for="salary">Salario bruto mensual</label>
        <input
            id="salary"
            name="salary"
            type="number"
            min="0.01"
            max="1000000"
            step="0.01"
            value="{{ old('salary', $salary ?? '') }}"
            required
        >
        @error('salary')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="frequency">Frecuencia de pago</label>
        <select id="frequency" name="frequency">
            @foreach (config('payroll.frequencies') as $key => $item)
                <option value="{{ $key }}" @selected(old('frequency', $frequency ?? 'mensual') === $key)>
                    {{ $item['label'] }}
                </option>
            @endforeach
        </select>
        @error('frequency')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Calcular salario</button>
    </form>

    @isset($result)
        <h2>Desglose del trabajador ({{ config('payroll.frequencies')[$result->frequency]['label'] }})</h2>
        <p>Montos del periodo. Salario bruto mensual ingresado: USD {{ number_format($salary, 2) }}.</p>
        <dl>
            <div><dt>Salario bruto</dt><dd>USD {{ number_format($result->grossSalary, 2) }}</dd></div>
            <div><dt>ISSS trabajador</dt><dd>- USD {{ number_format($result->employeeIsss, 2) }}</dd></div>
            <div><dt>AFP trabajador</dt><dd>- USD {{ number_format($result->employeeAfp, 2) }}</dd></div>
            <div><dt>Base ISR</dt><dd>USD {{ number_format($result->taxableBase, 2) }}</dd></div>
            <div><dt>ISR</dt><dd>- USD {{ number_format($result->incomeTax, 2) }}</dd></div>
            <div class="total"><dt>Salario neto</dt><dd>USD {{ number_format($result->netSalary, 2) }}</dd></div>
        </dl>

        <h2>Costo patronal básico</h2>
        <dl>
            <div><dt>ISSS patronal</dt><dd>USD {{ number_format($result->employerIsss, 2) }}</dd></div>
            <div><dt>AFP patronal</dt><dd>USD {{ number_format($result->employerAfp, 2) }}</dd></div>
            <div class="total"><dt>Costo estimado</dt><dd>USD {{ number_format($result->employerCost, 2) }}</dd></div>
        </dl>
    @endisset
</main>
</body>
</html>