<?php

return [

    'label' => 'Пагінація',

    'overview' => 'Показано з :first по :last з :total',

    'fields' => [

        'records_per_page' => [

            'label' => 'на сторінку',

            'options' => [
                'all' => 'Все',
            ],

        ],

    ],

    'actions' => [

        'first' => [
            'label' => 'Перша',
        ],

        'go_to_page' => [
            'label' => 'Перейти на сторінку :page',
        ],

        'last' => [
            'label' => 'Остання',
        ],

        'next' => [
            'label' => 'Наступна',
        ],

        'previous' => [
            'label' => 'Попередня',
        ],

    ],

];
