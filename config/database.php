<?php
//local

// Database configuration for shared hosting
return [
    'host' => 'localhost',
    'database' => 'np02cs4a240019',
    'username' => 'np02cs4a240019',
    'password' => '0i3MRr1IuJ',
    'charset' => 'utf8mb4',
    'port' => '3306',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 10, // Connection timeout
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ]
];
<<<<<<< Updated upstream
=======





// Database configuration for shared hosting
// return [
//     'host' => 'localhost',
//     'database' => 'np02cs4a240019',
//     'username' => 'np02cs4a240019',
//     'password' => '0i3MRr1IuJ',
//     'charset' => 'utf8mb4',
//     'port' => '3306',
//     'options' => [
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//         PDO::ATTR_EMULATE_PREPARES => false,
//         PDO::ATTR_TIMEOUT => 10, // Connection timeout
//         PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
//     ]
// ];



>>>>>>> Stashed changes
