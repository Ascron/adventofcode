<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

class CookieStorage
{
    public function __construct(
        private readonly string $cookieFilePath,
    ) {
    }

    public function exists(): bool
    {
        return file_exists($this->cookieFilePath);
    }

    public function store(string $cookie): void
    {
        file_put_contents($this->cookieFilePath, $cookie);
    }

    public function get(): string
    {
        return file_get_contents($this->cookieFilePath);
    }

    public function delete(): void
    {
        unlink($this->cookieFilePath);
    }
}