<?php


return [
    'fetch' => \PDO::FETCH_CLASS,
    'default' => env('DB_CONNECTION'),

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ],
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => 3306,
            'database'  => env('DB_DATABASE','users'),
            'username'  => env('DB_USERNAME','root'),
            'password'  => env('DB_PASSWORD','root'),
            'charset'   => env('DB_CHARSET', 'utf8'),
            'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
            'prefix'    => env('DB_PREFIX', '')
        ],
    ],

    'migrations' => 'migrations',
    'redis' => [
        'cluster' => false,
        'client' =>  env('REDIS_CLIENT', 'predis'),
    
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],
    
        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],
    
    ],
];
