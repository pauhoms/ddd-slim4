<?php
return [
    'Authentication-mysql' => [
        'cache_dir' => __DIR__ . '/../../../var/doctrine',
        'metadata_dirs' => [__DIR__ . '/../../../src/Domain'],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'dbname' => 'example',
            'user' => 'user',
            'password' => 'password'
        ]
    ]
];
