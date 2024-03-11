<?php


interface IDownloader
{
    public function download(string $url): string;
}


class SimpleDownloader implements IDownloader
{
    public function download(string $url): string
    {
        return file_get_contents($url) ?? '';
    }
}

class CURLDownloader implements IDownloader
{
    public function download(string $url): string
    {
        // curl
        return "";
    }
}

class A extends SimpleDownloader{}

class CacheSimpleDownloader implements IDownloader
{
    protected array $results = [];

    protected IDownloader $downloader;

    /**
     * @param IDownloader $downloader
     */
    public function __construct(IDownloader $downloader)
    {
        $this->downloader = $downloader;
    }


    public function download(string $url): string
    {
        return $this->results[$url] ?? $this->results[$url] = $this->downloader->download($url);
    }
}



function app(array $urls, IDownloader $downloader)
{
    foreach ($urls as $url) {
        $result = $downloader->download($url);
    }
}


//$downloader = new CacheSimpleDownloader(new SimpleDownloader());
$downloader = new CacheSimpleDownloader(new CURLDownloader());
app(
    [
        'https://google.com',
        'https://facebook.com',
        'https://nv.ua',
        'https://google.com',
        'https://facebook.com',
        'https://google.com',
        'https://facebook.com',
        'https://google.com',
        'https://facebook.com',
        'https://google.com',
        'https://facebook.com',
    ],
    $downloader
);




$html = file_get_contents('https://google.com');

exit;