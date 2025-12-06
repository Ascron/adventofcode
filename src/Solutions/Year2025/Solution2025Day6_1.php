<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/6
 */
class Solution2025Day6_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $numbers = [];

        foreach (Lines::fromInput($input) as $line) {
            preg_match_all('#[^\s]+#', $line, $matches);
            foreach ($matches[0] as $index => $match) {
                $numbers[$index][] = is_numeric($match) ? (int) $match : $match;
            }
        }

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

        $output = '4277556';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}