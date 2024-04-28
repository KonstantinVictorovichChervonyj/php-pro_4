<?php

namespace App\Controllers;

class ErrorController
{
    const SERVER_ERROR = 500;
    const NOT_FOUND = 404;

    public function getError(string $url, int $error = self::SERVER_ERROR): string
    {
        if ($error === self::NOT_FOUND) {
            return 'URI Not Found: ' . $url;
        } else {
            return 'Server Error';
        }
    }
}