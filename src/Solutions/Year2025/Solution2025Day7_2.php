<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/7#part2
 */
class Solution2025Day7_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $map = [];
        foreach (Lines::fromInput($input) as $line) {
            if (strpos($line, 'S') === false && strpos($line, '^') === false) {
                continue;
            }
            $map[] = str_split($line);
        }

        $beams = [];
        foreach ($map[0] as $x => $cell) {
            if ($cell === 'S') {
                $beams[$x] = 1;
                break;
            }
        }

        foreach ($map as $row) {
            if (!in_array('^', $row, true)) {
                continue;
            }
            $newBeams = [];
            foreach ($row as $x => $cell) {
                if ($cell === '^' && array_key_exists($x, $beams)) {
                    $newBeams[$x - 1] = ($newBeams[$x - 1] ?? 0) + $beams[$x];
                    $newBeams[$x + 1] = ($newBeams[$x + 1] ?? 0) + $beams[$x];
                    unset($beams[$x]);
                }
            }

            foreach ($beams as $x => $count) {
                $newBeams[$x] = ($newBeams[$x] ?? 0) + $count;
            }
            $beams = $newBeams;
        }

        return (string) array_sum($beams);
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

        $output = '40';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        }
    }
}