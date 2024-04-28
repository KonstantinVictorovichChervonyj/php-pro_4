<?php

use App\Controllers\ErrorController;
use App\Controllers\UrlCodeController;
use App\Core\Exceptions\RouteNotFoundException;
use App\Shortener\DatabaseRepository;
use App\Shortener\Models\UrlCode;

require_once __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$pathParts = explode('/', substr($uri, 1));

try {
    $controllerClass = match (array_shift($pathParts)) {
        'error' => ErrorController::class,
        'shortener' => UrlCodeController::class,
        default => throw new RouteNotFoundException('Uri: $uri not found'),
    };
    $controller = new $controllerClass(new DatabaseRepository(new UrlCode()));
    echo $controller->getInfo($pathParts[0]);
} catch (\Exception $e) {
    $controller = new ErrorController;
    echo $controller->getError($uri, 404);
} catch (\Error $e) {
    echo $e->getMessage();
    $controller = new ErrorController;
    echo $controller->getError('', 500);
}