<?php

return [
    'isss_employee_rate' => 0.03,
    'isss_employer_rate' => 0.075,
    'afp_employee_rate' => 0.0725,
    'afp_employer_rate' => 0.0875,
    'maximum_salary' => 1000000.00,
    'effective_from' => '2025-04-30',
    'frequencies' => [
        'mensual' => [
            'label' => 'Mensual',
            'payments_per_month' => 1,
            'isss_ceiling' => 1000.00,
            'isr' => [
                'exempt_limit' => 550.00,
                'second_limit' => 895.24,
                'third_limit' => 2038.10,
                'second_fixed' => 17.67,
                'third_fixed' => 60.00,
                'fourth_fixed' => 288.57,
            ],
        ],
        'quincenal' => [
            'label' => 'Quincenal',
            'payments_per_month' => 2,
            'isss_ceiling' => 500.00,
            'isr' => [
                'exempt_limit' => 275.00,
                'second_limit' => 447.62,
                'third_limit' => 1019.05,
                'second_fixed' => 8.83,
                'third_fixed' => 30.00,
                'fourth_fixed' => 144.28,
            ],
        ],
        'semanal' => [
            'label' => 'Semanal',
            'payments_per_month' => 4,
            'isss_ceiling' => 250.00,
            'isr' => [
                'exempt_limit' => 137.50,
                'second_limit' => 223.81,
                'third_limit' => 509.52,
                'second_fixed' => 4.42,
                'third_fixed' => 15.00,
                'fourth_fixed' => 72.14,
            ],
        ],
    ],
];
