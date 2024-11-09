<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2015;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;

/**
 * @see https://adventofcode.com/2015/day/1
 */
class Solution2015Day1_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $symbolCount = count_chars($input, 1);
        $result = ($symbolCount[ord('(')] ?? 0) - ($symbolCount[ord(')')] ?? 0);

        return (string) $result;
    }
    
    public function testSolution1(): void
    {
        if ($this->solve('(())') !== '0') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution2(): void
    {
        if ($this->solve('()()') !== '0') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution3(): void
    {
        if ($this->solve('(((') !== '3') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution4(): void
    {
        if ($this->solve('(()(()(') !== '3') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution5(): void
    {
        if ($this->solve('))(((((') !== '3') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution6(): void
    {
        if ($this->solve('())') !== '-1') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution7(): void
    {
        if ($this->solve('))(') !== '-1') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution8(): void
    {
        if ($this->solve(')))') !== '-3') {
            throw new RuntimeException('Test failed');
        }
    }

    public function testSolution9(): void
    {
        if ($this->solve(')())())') !== '-3') {
            throw new RuntimeException('Test failed');
        }
    }
}