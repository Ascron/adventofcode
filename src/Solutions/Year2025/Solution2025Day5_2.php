<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/5#part2
 */
class Solution2025Day5_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;
        $zones = [];
        foreach (Lines::fromInput($input) as $line) {
            if ($line === '') {
                continue;
            }
            if (strpos($line, '-') === false) {
                // do nothing
            } else {
                [$start, $end] = explode('-', $line);
                $start = (int) $start;
                $end = (int) $end;
                if (array_key_exists($start, $zones)) {
                    $zones[$start] = max($end, $zones[$start]);
                } else {
                    $zones[$start] = $end;
                }
            }
        }

        ksort($zones);

        while (true) {
            $changed = false;

            foreach ($zones as $start => $end) {
                $nextEnd = next($zones);
                $nextStart = key($zones);
                if ($nextEnd === false) {
                    break;
                }

                if ($nextStart <= $end) {
                    $zones[$start] = max($end, $nextEnd);
                    unset($zones[$nextStart]);
                    $changed = true;
                }

            }

            if (!$changed) {
                break;
            }
        }

        foreach ($zones as $start => $end) {
            $result += ($end - $start + 1);
        }


        return (string) $result;
    }

    public function test1(): void
    {
        $input = <<<AOC
            3-5
            10-14
            16-20
            12-18
            
            32
            1
            5
            8
            11
            17
            AOC;

        $output = '14';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        }
    }
}