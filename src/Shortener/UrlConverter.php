<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeRepository;
use App\Shortener\Interfaces\IUrlDecoder;
use App\Shortener\Interfaces\IUrlEncoder;
use App\Shortener\Interfaces\IUrlValidator;
use App\Shortener\ValueObjects\UrlCodePair;
use InvalidArgumentException;

class UrlConverter implements IUrlDecoder, IUrlEncoder
{

    const CODE_LENGTH = 6;
    const CODE_CHAIRS = '0123456789abcdefghijklmnopqrstuvwxyz';

    /**
     * @param ICodeRepository $repository
     * @param IUrlValidator $validator
     * @param int $codeLength
     */
    public function __construct(
        protected ICodeRepository $repository,
        protected IUrlValidator $validator,
        protected int $codeLength = self::CODE_LENGTH
    )
    {

    }

    /**
     * @param string $code
     * @throws InvalidArgumentException
     * @return string
     */
    public function decode(string $code): string
    {
        try {
            $url = $this->repository->getUrlByCode($code);
        } catch (DataNotFoundException $e) {
            throw new InvalidArgumentException(
                $e->getMessage(),
                $e->getCode(),
                $e->getPrevious()
            );
        }
        return $url;
    }

    /**
     * @param string $url
     * @throws InvalidArgumentException
     * @return string
     */
    public function encode(string $url): string
    {
        $this->validateUrl($url);
        try {
            $code = $this->repository->getCodeByUrl($url);
        } catch (DataNotFoundException) {
            $code = $this->generateAndSaveCode($url);
        }
        return $code;
    }

    public function validateUrl(string $url): bool
    {
        $this->validator->validateUrl($url);
        $this->validator->checkUrl($url);
        return true;
    }

    public function generateAndSaveCode(string $url): string
    {
        $code = $this->createUnicode();
        $this->repository->saveEntity(new UrlCodePair($code, $url));
        return $code;
    }

    public function createUnicode()
    {
        $date = new \DateTime();
        $str = self::CODE_CHAIRS . mb_strtoupper(self::CODE_CHAIRS) . $date->getTimestamp();
        $code = substr(str_shuffle($str), 0, $this->codeLength);
        if ($this->repository->codeIsset($code)) {
            $code = $this->createUnicode();
        }
        return $code;
    }
}