<?php

return [
    'api_key' => env('RAJAONGKIR_API_KEY'),
    'origin_city_id' => env('RAJAONGKIR_ORIGIN_CITY_ID', '501'), // Jakarta
    'couriers' => [
        'jne' => 'JNE',
        'pos' => 'POS Indonesia',
        'tiki' => 'TIKI',
    ],
    'services' => [
        'jne' => [
            'REG' => 'Reguler',
            'OKE' => 'Oke',
            'YES' => 'Yes',
        ],
        'pos' => [
            'P不快' => 'Pos Kilat Khusus',
            'POS' => 'Pos Tambahan',
            'TIKI' => 'TIKI',
        ],
        'tiki' => [
            'REG' => 'Reguler',
            'ECO' => 'Economi',
            'ONS' => 'Oneshot',
        ],
    ],
];