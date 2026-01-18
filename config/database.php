<?php

return [
    'host' => '127.0.0.1',
    'database' => 'library_system',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'port' => '3306',
    'unix_socket' => '/opt/lampp/var/mysql/mysql.sock',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];


