<?php

return [
    'ip' => env('KAPRI_IP', '192.168.0.248'),
    'instruction_password' => env('KAPRI_PWD', ''),
    'reset_delay_sec' => env('KAPRI_RESET_DELAY', 3),

    'cards' => [
        'ABC12345' => 'Omar',
        'FFEE1122' => 'Ali',
    ],

    'qrcodes' => [
        'VIP123' => 'Guest Omar',
        'PASS456' => 'Guest Ali',
    ],
];
