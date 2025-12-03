<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/3
 */
class Solution2025Day3_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        foreach (Lines::fromInput($input) as $line) {
            $numbers = str_split($line);
            $firstNumbers = array_slice($numbers, 0, count($numbers) - 1, preserve_keys: true);
            $maxNumber = max($firstNumbers);
            $index = array_search($maxNumber, $firstNumbers);
            $lastNumbers = array_slice($numbers, $index + 1, preserve_keys: true);
            $result += (int) ($maxNumber . max($lastNumbers));
        }

        return (string) $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            987654321111111
            811111111111119
            234234234234278
            818181911112111
            AOC;

        $output = '357';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}