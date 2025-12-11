<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/11
 */
class Solution2025Day11_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        $map = [];
        foreach (Lines::fromInput($input) as $line) {
            [$input, $outputs] = explode(': ', $line);
            $outputs = explode(' ', $outputs);
            $map[$input] = $outputs;
        }

        return (string) $this->search('you', $map);
    }

    private function search($input, $map): int
    {
        if ($input === 'out') {
            return 1;
        }

        $result = 0;
        foreach ($map[$input] as $output) {
            $result += $this->search($output, $map);
        }

        return $result;
    }
    
    public function test1(): void
    {
        $input = <<<AOC
            aaa: you hhh
            you: bbb ccc
            bbb: ddd eee
            ccc: ddd eee fff
            ddd: ggg
            eee: out
            fff: out
            ggg: out
            hhh: ccc fff iii
            iii: out
            AOC;

        $output = '5';
        
        $testResult = $this->solve($input);
    
        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        } 
    }
}