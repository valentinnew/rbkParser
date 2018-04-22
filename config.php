<?php

$override = include(__DIR__ . '/config.local.php');

return array_merge([
    'db' => [
        'dsn' => 'mysql:dbname=testdb;host=127.0.0.1',
        'user' => 'dbuser',
        'passwd' => 'dbpass'
    ],
], $override);