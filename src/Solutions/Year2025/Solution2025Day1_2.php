<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/1#part2025
 */
class Solution2025Day1_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 50;

        $counter = 0;

        foreach (Lines::fromInput($input) as $line) {

            echo $line . ' - ' . $result . PHP_EOL;
            $add = true;
            if ($line[0] === 'L') {
                $add = false;
            }

            $line = str_replace(['L', 'R'], '', $line);
            $number = (int) $line;

            $resultBefore = $result;

            $counterInc = (int) floor($number / 100);
            if ($counterInc > 0) {
                $counter += $counterInc;
                $number -= $counterInc * 100;
            }

            if ($add) {
                $result += $number;
            } else {
                $result -= $number;
            }

            if ($resultBefore % 100 === 0) {
                // do nothing
            } elseif ($result % 100 === 0) {
                $counter++;
            } elseif ($resultBefore < 0 && $result > 0) {
                $counter++;
            } elseif ($resultBefore > 0 && $result < 0) {
                $counter++;
            }

            if ($result > 100) {
                $counter++;
            }

            if ($result < 0) {
                $result = 100 + $result;
            }

            $result = $result % 100;

            echo $result . ' - [' . $counter . ']' . PHP_EOL;
        }

        return (string) $counter;
    }

    public function test1(): void
    {
        $input = <<<AOC
            L68
            L30
            R48
            L5
            R60
            L55
            L1
            L99
            R14
            L82
            AOC;

        $output = '6';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new ('Test failed with result ' . $testResult);
        }
    }

    public function test2(): void
    {
        $input = <<<AOC
            L68
            L30
            R48
            L5
            R60
            L55
            L1
            L99
            R14
            L82
            R300
            L300
            R168
            AOC;

        $output = '14';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new ('Test failed with result ' . $testResult);
        }
    }
}