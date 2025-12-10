<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/10
 */
class Solution2025Day10_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $machines = [];
        foreach (Lines::fromInput($input) as $line) {
            $elements = explode(' ', $line);
            $indicatorArray = array_map(fn($symbol) => $symbol === '#' ? 1 : 0, str_split(trim($elements[0], '[]')));
            $indicator = 0;
            foreach ($indicatorArray as $index => $value) {
                if ($value === 0) {
                    continue;
                }
                $indicator += $value << $index;
            }
            $buttons = array_slice($elements, 1, -1);
            $buttons = array_map(function ($b) {
                $buttons = array_map(intval(...), explode(',', trim($b, '()')));
                $result = 0;
                foreach ($buttons as $index) {
                    $result += 1 << $index;
                }
                return $result;
            }, $buttons);
            $joltage = array_map(intval(...), explode(',', trim($elements[count($elements) - 1], '{}')));
            $machines[] = [
                $indicator,
                $buttons,
                $joltage,
            ];
        }

        foreach ($machines as $machine) {
            [$indicator, $buttons] = $machine;
            $res = $this->indicatorSearch($indicator, $buttons);
            $result += $res;
        }

        return (string) $result;
    }

    private function indicatorSearch(int $indicator, array $buttons): int
    {
        $summs = [$indicator];
        $deep = 0;

        while (true) {
            $newSumms = [];
            foreach ($buttons as $button) {
                foreach ($summs as $summ) {
                    $newSumm = $summ ^ $button;
                    if ($newSumm === 0) {
                        return $deep + 1;
                    }
                    $newSumms[] = $newSumm;
                }
            }
            $summs = $newSumms;
            $deep++;
        }
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            [.##.] (3) (1,3) (2) (2,3) (0,2) (0,1) {3,5,4,7}
            [...#.] (0,2,3,4) (2,3) (0,4) (0,1,2) (1,2,3,4) {7,5,12,7,2}
            [.###.#] (0,1,2,3,4) (0,3,4) (0,1,2,4,5) (1,2) {10,11,11,5,10,5}
            AOC;

        $output = '7';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}