<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/4
 */
class Solution2025Day4_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $map = [];
        foreach (Lines::fromInput($input) as $line) {
            $map[] = str_split($line);
        }

        foreach ($map as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell !== '@') {
                    continue;
                }

                $adjacentDeltas = [
                    [-1, 0],
                    [1, 0],
                    [0, -1],
                    [0, 1],
                    [-1, -1],
                    [1, -1],
                    [-1, 1],
                    [1, 1],
                ];
                $around = 0;
                foreach ($adjacentDeltas as [$dx, $dy]) {
                    $nx = $x + $dx;
                    $ny = $y + $dy;
                    if (isset($map[$ny][$nx]) && $map[$ny][$nx] === '@') {
                        $around++;
                    }
                }
                if ($around < 4) {
                    $result++;
                }
            }
        }

        return (string) $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            ..@@.@@@@.
            @@@.@.@.@@
            @@@@@.@.@@
            @.@@@@..@.
            @@.@@@@.@@
            .@@@@@@@.@
            .@.@.@.@@@
            @.@@@.@@@@
            .@@@@@@@@.
            @.@.@@@.@.
            AOC;

        $output = '13';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}