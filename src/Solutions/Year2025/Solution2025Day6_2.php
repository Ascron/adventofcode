<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/6#part2
 */
class Solution2025Day6_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $map = [];
        foreach (Lines::fromInput($input, noTrim: true) as $line) {
            if ($line === '') {
                continue;
            }
            $map[] = str_split($line);
        }

        $numbers = [];
        $numbersIndex = 0;
        $operator = null;
        for ($i = 0, $c = count($map[0]); $i < $c; $i++) {
            $column = '';
            for ($j = 0, $r = count($map); $j < $r; $j++) {
                if ($map[$j][$i] === '+' || $map[$j][$i] === '*') {
                    $operator = $map[$j][$i];
                    continue;
                }
                $column .= $map[$j][$i];
            }
            $column = trim($column);

            if ($column === '') {
                $numbers[$numbersIndex][] = $operator;
                $numbersIndex++;
                continue;
            }

            $numbers[$numbersIndex][] = (int) $column;
        }

        $numbers[$numbersIndex][] = $operator;

        foreach ($numbers as $formula) {
            $lastKey = max(array_keys($formula));
            $formulaResult = null;
            for ($i = 0; $i < $lastKey; $i++) {
                if ($i === 0) {
                    $formulaResult = $formula[$i];
                } else {
                    if ($formula[$lastKey] === '+') {
                        $formulaResult += $formula[$i];
                    } elseif ($formula[$lastKey] === '*') {
                        $formulaResult *= $formula[$i];
                    }
                }
            }

            $result += $formulaResult;
        }

        return (string) $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            123 328  51 64 
             45 64  387 23 
              6 98  215 314
            *   +   *   +  
            AOC;

        $output = '3263827';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}