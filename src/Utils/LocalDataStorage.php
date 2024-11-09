<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

class LocalDataStorage
{
    public function __construct(
        private readonly string $dataDirPath,
    ) {
    }

    public function inputExists(int $year, int $day): bool
    {
        return file_exists($this->createPath($year, $day));
    }

    public function getInput(int $year, int $day): string
    {
        return file_get_contents($this->createPath($year, $day));
    }

    private function createPath(int $year, int $day): string
    {
        return "{$this->dataDirPath}/{$year}/{$day}";
    }

    public function storeInput(int $year, int $day, string $input): void
    {
        $this->prepareDataFolder($year);
        file_put_contents($this->createPath($year, $day), $input);
    }

    private function prepareDataFolder(int $year): void
    {
        $yearDir = "{$this->dataDirPath}/{$year}";

        if (!file_exists($yearDir)) {
            mkdir($yearDir, recursive: true);
        }
    }
}