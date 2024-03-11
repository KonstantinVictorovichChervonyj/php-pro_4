<?php

namespace App\Shortener\ValueObjects;

class UrlCodePair
{
    public function __construct(protected string $code, protected string $url)
    {

    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}