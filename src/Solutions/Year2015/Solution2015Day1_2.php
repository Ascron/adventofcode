<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2015;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;

/**
 * @see https://adventofcode.com/2015/day/1#part2
 */
class Solution2015Day1_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $level = 0;
        for ($i = 0, $length = strlen($input); $i < $length; $i++) {
            if ($input[$i] === '(') {
                $level++;
            } else {
                $level--;
            }

            if ($level === -1) {
                break;
            }
        }

        return (string) ($i + 1);
    }
    
    public function testSolution1(): void
    {
        if ($this->solve(')') !== '1') {
            throw new RuntimeException('Test failed');
        } 
    }

    public function testSolution2(): void
    {
        if ($this->solve('()())') !== '5') {
            throw new RuntimeException('Test failed');
        }
    }
}