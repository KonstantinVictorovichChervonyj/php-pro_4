<?php

use App\Shortener\FileRepository;
use App\Shortener\Helpers\UrlValidator;
use App\Shortener\UrlConverter;
use GuzzleHttp\Client;


require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'dbFile' => __DIR__ . '/../storage/db.json',
    'urlConverter.codeLength' => 8
];

$fileRepository = new FileRepository($config['dbFile']);
$urlValidator = new UrlValidator(new Client());

$converter = new UrlConverter(
    $fileRepository,
    $urlValidator,
    $config['urlConverter.codeLength']
);

try {
    echo $converter->encode('https://facebook.com');
    echo PHP_EOL;
} catch (\Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

echo PHP_EOL;