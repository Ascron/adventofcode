<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2023;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use Ascron\Adventofcode\Utils\Lines;
use RuntimeException;

/**
 * @see https://adventofcode.com/2023/day/1#part2
 */
class Solution2023Day1_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        // Replacing digits without removing link-characters
        $digits = [
            'one' => 'o1e',
            'two' => 't2o',
            'three' => 't3e',
            'four' => '4',
            'five' => '5e',
            'six' => '6',
            'seven' => '7n',
            'eight' => 'e8t',
            'nine' => 'n9e',
        ];

        $result = 0;
        foreach (Lines::fromInput($input) as $line) {
            $line = str_replace(array_keys($digits), array_values($digits), $line);
            preg_match_all('#\d#', $line, $matches);
            $result += (int) ($matches[0][0] . '' . array_pop($matches[0]));
        }

        return (string) $result;
    }
    
    public function testExample(): void
    {
        $input = <<<'EOD'
two1nine
eightwothree
abcone2threexyz
xtwone3four
4nineeightseven2
zoneight234
7pqrstsixteen   
EOD;

        if ($this->solve($input) !== '281') {
            throw new RuntimeException('Test failed');
        } 
    }
}