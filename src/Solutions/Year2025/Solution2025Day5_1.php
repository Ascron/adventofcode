<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/5
 */
class Solution2025Day5_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;
        $numbers = [];
        $zones = [];
        foreach (Lines::fromInput($input) as $line) {
            if ($line === '') {
                continue;
            }
            if (strpos($line, '-') === false) {
                $numbers[] = (int) $line;
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
        sort($numbers);

        foreach ($zones as $start => $end) {
            $current = current($numbers);

            while ($current <= $end) {
                if ($current >= $start && $current <= $end) {
                    $result++;
                    echo "Number {$current} is in zone {$start}-{$end}" . PHP_EOL;
                }

                $current = next($numbers);
            }
        }

        return (string) $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            12-18
            3-5
            10-14
            16-20
            
            32
            1
            5
            8
            11
            17
            AOC;

        $output = '3';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}