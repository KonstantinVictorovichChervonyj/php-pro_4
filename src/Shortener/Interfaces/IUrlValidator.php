<?php

namespace App\Shortener\Interfaces;

use InvalidArgumentException;

interface IUrlValidator
{
    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function validateUrl(string $url): bool;

    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return bool
     */
    public function checkUrl(string $url): bool;

}