<?php

namespace App\Controllers;

use App\Shortener\DatabaseAR;
use App\Shortener\DatabaseRepository;
use App\Shortener\Exceptions\DataNotFoundException;

class UrlCodeController
{
    public function __construct (protected DatabaseRepository $database)
    {
        new DatabaseAR('base', 'doctor', 'pass4doctor', 'db_mysql');
    }

    /**
     * @throws DataNotFoundException
     */
    public function getInfo(string $code): string
    {
        return $this->database->getUrlByCode($code);
    }
}