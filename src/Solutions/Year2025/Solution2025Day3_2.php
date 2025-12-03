<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/3#part2
 */
class Solution2025Day3_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        foreach (Lines::fromInput($input) as $line) {
            $numbers = str_split($line);
            $result += $this->glueNumber($numbers);
        }

        return (string) $result;
    }

    private function glueNumber(array $numbers): int
    {
        $length = 12;
        $result = '';
        $index = 0;

        for ($i = 0; $i < 12; $i++) {
            $numbersPart = array_slice($numbers, $index, count($numbers) - $length + 1 - $index + strlen($result), preserve_keys: true);
            $max = max($numbersPart);
            $index = array_search($max, $numbersPart) + 1;
            $result .= $max;
        }

        echo $result . PHP_EOL;

        return (int) ($result);
    }

    public function test1(): void
    {
        $input = <<<AOC
            987654321111111
            811111111111119
            234234234234278
            818181911112111
            AOC;

        $output = '3121910778619';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        }
    }
}