<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

class Lines
{
    public static function fromInput(string $input): array
    {
        return array_map(trim(...), explode("\n", trim($input)));
    }
}