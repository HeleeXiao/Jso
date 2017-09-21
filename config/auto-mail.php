<?php
return [

    'default' => env('AUTO_MAIL_SERVER', 'dev'),

    'connections' => [
        "dev" => [
            "host"          => 'https://b015.repica.jp/tm/lpmail.php',
            "name"          => "Wj5Z-01",
            "password"      => "YK25FNNg",
            "site_id"       => "173",
            "service_id"    => "298",
        ],

        "pro" => [
            "host"          => 'https://b091.repica.jp/tm/lpmail.php',
            "name"          => "cool-01",
            //"password"      => "CrKx69bU",
            "password"      => "HgegZNQw3a",
            "site_id"       => "10",
            "service_id"    => "13",
        ],
    ],

    'sender' => [
        'name' => '株式会社COOL',
        'email' => 'info@c8l.jp'
    ]
];