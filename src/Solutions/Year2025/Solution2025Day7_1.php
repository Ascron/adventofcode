<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/7
 */
class Solution2025Day7_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $map = [];

        foreach (Lines::fromInput($input) as $line) {
            $map[] = str_split($line);
        }

        $beams = [];

        foreach ($map as $y => $row) {
            foreach ($row as $x => $cell) {
                switch ($cell) {
                    case 'S':
                        $beams[$x] = 1;
                        break;
                    case '^':
                        if (array_key_exists($x, $beams)) {
                            unset($beams[$x]);
                            $beams[$x - 1] = 1;
                            $beams[$x + 1] = 1;
                            $result++;
                        }
                        break;
                }
            }
        }

        return (string) $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            .......S.......
            ...............
            .......^.......
            ...............
            ......^.^......
            ...............
            .....^.^.^.....
            ...............
            ....^.^...^....
            ...............
            ...^.^...^.^...
            ...............
            ..^...^.....^..
            ...............
            .^.^.^.^.^...^.
            ...............
            AOC;

        $output = '21';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}