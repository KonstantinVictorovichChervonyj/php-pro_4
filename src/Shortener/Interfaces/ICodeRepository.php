<?php

namespace App\Shortener\Interfaces;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\ValueObjects\UrlCodePair;

interface ICodeRepository
{
    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlCodePair): bool;

    /**
     * @param string $code
     * @return bool
     */
    public function codeIsset(string $code): bool;

    /**
     * @param string $code
     * @throws DataNotFoundException
     * @return string
     */
    public function getUrlByCode(string $code): string;

    /**
     * @param string $url
     * @throws DataNotFoundException
     * @return string
     */
    public function getCodeByUrl(string $url): string;

}