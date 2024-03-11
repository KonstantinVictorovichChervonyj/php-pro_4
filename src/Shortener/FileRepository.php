<?php

namespace App\Shortener;

use App\Shortener\Exceptions\DataNotFoundException;
use App\Shortener\Interfaces\ICodeRepository;
use App\Shortener\ValueObjects\UrlCodePair;

class FileRepository implements ICodeRepository
{
    protected array $db = [];

    /**
     * @param string $fileDb
     */
    public function __construct(protected string $fileDb)
    {
        $this->getDbFromStorage();
    }

    /**
     * @return void
     */
    protected function getDbFromStorage(): void
    {
        if (file_exists($this->fileDb)) {
            $content = file_get_contents($this->fileDb);
            $this->db = (array)json_decode($content, true);
        }
    }

    /**
     * @param UrlCodePair $urlCodePair
     * @return bool
     */
    public function saveEntity(UrlCodePair $urlCodePair): bool
    {
        $this->db[$urlCodePair->getCode()] = $urlCodePair->getUrl();
        return true;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function codeIsset(string $code): bool
    {
        return isset($this->db[$code]);
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
        return $this->db[$code];
    }

    /**
     * @param string $url
     * @throws DataNotFoundException
     * @return string
     */
    public function getCodeByUrl(string $url): string
    {
        if (!$code = array_search($url, $this->db)) {
            throw new DataNotFoundException();
        }
        return $code;
    }

    protected function writeFile(string $content): void
    {
        $file = fopen($this->fileDb, 'w+');
        fwrite($file, $content);
        fclose($file);
    }

    public function __destruct()
    {
        $this->writeFile(json_encode($this->db, JSON_PRETTY_PRINT));
    }
}