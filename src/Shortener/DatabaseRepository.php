<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeRepository;
use App\Shortener\Models\UrlCode;
use App\Shortener\ValueObjects\UrlCodePair;

class DatabaseRepository implements ICodeRepository
{

    /**
     * @param UrlCode $urlCode
     */
    public function __construct(protected UrlCode $urlCode)
    {

    }

    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlCodePair): bool
    {
        $this->urlCode->fill([
            'url' => $urlCodePair->getUrl(),
            'code' => $urlCodePair->getCode()
        ]);
        return true;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function codeIsset(string $code): bool
    {
        return $this->urlCode::where('code', $code)->exists();
    }

    /**
     * @param string $url
     * @return bool
     */
    public function urlIsset(string $url): bool
    {
        return $this->urlCode::where('url', $url)->exists();
    }

    /**
     * @param string $code
     * @throws DataNotFoundException
     * @return string
     */
    public function getUrlByCode(string $code): string
    {
        if (!$this->codeIsset($code)) {
            throw new DataNotFoundException();
        }
        return $this->urlCode::where('code', $code)->value('url');
    }

    /**
     * @param string $url
     * @throws DataNotFoundException
     * @return string
     */
    public function getCodeByUrl(string $url): string
    {
        if (!$this->urlIsset($url)) {
            throw new DataNotFoundException();
        }
        return $this->urlCode::where('url', $url)->value('code');
    }
}