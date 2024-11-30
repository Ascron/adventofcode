<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2023;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use Ascron\Adventofcode\Utils\Lines;
use RuntimeException;

/**
 * @see https://adventofcode.com/2023/day/1
 */
class Solution2023Day1_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        foreach (Lines::fromInput($input) as $line) {
            preg_match_all('#\d#', $line, $matches);
            $result += (int) ($matches[0][0] . '' . array_pop($matches[0]));
        }

        return (string) $result;
    }
    
    public function testSolution1(): void
    {
        $input = <<<'EOD'
1abc2
pqr3stu8vwx
a1b2c3d4e5f
treb7uchet
EOD;

        if ($this->solve($input) !== '142') {
            throw new RuntimeException('Test failed');
        } 
    }
}