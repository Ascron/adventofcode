<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

use Ascron\Adventofcode\Utils\AdventApi\AdventApi;

class DataProvider
{
    public function __construct(
        private readonly AdventApi $api,
        private readonly LocalDataStorage $localDataStorage,
    ) {
    }

    public function getInput(int $year, int $day): string
    {
        if ($this->localDataStorage->inputExists($year, $day)) {
            return $this->localDataStorage->getInput($year, $day);
        }

        $input = $this->api->getInput($year, $day);
        $this->localDataStorage->storeInput($year, $day, $input);

        return $input;
    }

    public function exists(int $year, int $day): bool
    {
        return $this->localDataStorage->inputExists($year, $day);
    }
}