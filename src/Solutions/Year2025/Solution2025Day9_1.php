<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/9
 */
class Solution2025Day9_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $dots = [];
        foreach (Lines::fromInput($input) as $line) {
            $dots[] = array_map(intval(...), explode(',', $line));
        }

        $areas = [];

        for ($i = 0, $c = count($dots); $i < $c; $i++) {
            for ($j = $i + 1; $j < $c; $j++) {
                $areas[$i . '-' . $j] = abs($dots[$i][0] - $dots[$j][0] + 1) * abs($dots[$i][1] - $dots[$j][1] + 1);
            }
        }

        return (string) max($areas);
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            7,1
            11,1
            11,7
            9,7
            9,5
            2,5
            2,3
            7,3
            AOC;

        $output = '50';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}