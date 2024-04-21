<?php

namespace App\Shortener;

use Illuminate\Database\Capsule\Manager;

class DatabaseAR
{
    const DRIVER = 'mysql';
    const HOST = 'localhost';
    const PREFIX = '';
    const CHARSET = 'utf8';
    const COLLATE = 'utf8_unicode_ci';

    public function __construct(
        string $database,
        string $username,
        string $password,
        string $host = self::HOST,
        string $prefix = self::PREFIX,
        string $charset = self::CHARSET,
        string $collate = self::COLLATE,
        string $driver = self::DRIVER
    )
    {
        $dbManager = new Manager();
        $dbManager->addConnection([
            'driver'    => $driver,
            'host'      => $host,
            'database'  => $database,
            'username'  => $username,
            'password'  => $password,
            'charset'   => $charset,
            'collation' => $collate,
            'prefix'    => $prefix,
        ]);

        $dbManager->bootEloquent();
    }
}