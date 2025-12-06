<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

class Lines
{
    public static function fromInput(string $input, string $separator = "\n", bool $noTrim = false): array
    {
        if ($noTrim) {
            return explode($separator, $input);
        }

        return array_map(trim(...), explode($separator, trim($input)));
    }
}