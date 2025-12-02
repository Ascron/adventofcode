<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/2
 */
class Solution2025Day2_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $testStart = 1;
        $testEnd = 99999;

        $data = [];
        foreach (Lines::fromInput($input, ',') as $line) {
            [$start, $end] = explode('-', $line);
            $data[(int) $start] = (int) $end;
        }
        ksort($data);

        $minLen = 2;
        $maxLen = 10;
        $numbers = [];
        for ($len = $minLen; $len <= $maxLen; $len++) {
            reset($data);
            $currentStart = key($data);
            $currentEnd = $data[$currentStart];
            for ($i = $testStart; $i <= $testEnd; $i++) {
                // repeat $i $len times
                $number = (int) str_repeat((string) $i, $len);

                if (in_array($number, $numbers, strict: true)) {
                    continue;
                }

                while ($number > $currentEnd) {
                    $nextValue = next($data);
                    if ($nextValue === false) {
                        break;
                    }
                    $currentStart = key($data);
                    $currentEnd = $data[$currentStart];
                }

                if ($number < $currentStart) {
                    continue;
                }

                if ($number >= $currentStart && $number <= $currentEnd) {
                    echo 'Adding number: ' . $number . ' [' . $currentStart . '-' . $currentEnd . ']' . PHP_EOL;
                    $result += $number;
                    $numbers[] = $number;
                }
            }
        }

        return (string) $result;
    }

    public function test1(): void
    {
        $input = <<<AOC
            11-22,95-115,998-1012,1188511880-1188511890,222220-222224,1698522-1698528,446443-446449,38593856-38593862,565653-565659,824824821-824824827,2121212118-2121212124
            AOC;

        $output = '4174379265';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        }
    }
}