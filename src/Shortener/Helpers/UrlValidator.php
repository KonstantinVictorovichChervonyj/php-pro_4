<?php

namespace App\Shortener\Helpers;

use App\Shortener\Interfaces\IUrlValidator;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use InvalidArgumentException;

class UrlValidator implements IUrlValidator
{

    public function __construct(protected ClientInterface $client)
    {
    }

    public function validateUrl(string $url): bool
    {
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Url is broken or not valid');
        }
        return true;
    }

    public function checkUrl(string $url): bool
    {
        $allowCodes = [
            200,
            201,
            301,
            302
        ];
        try {
            $response = $this->client->get($url);
            return (!empty($response->getStatusCode()) && in_array($response->getStatusCode(), $allowCodes));
        } catch (ConnectException $exception) {
            throw new InvalidArgumentException($exception->getMessage(), $exception->getCode());
        }
    }
}