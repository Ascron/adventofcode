<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2016;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2016/day/1
 */
class Solution2016Day1_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $directions = [
            0 => 'down',
            1 => 'left',
            2 => 'up',
            3 => 'right',
        ];

        $direction = 0;
        $x = 0;
        $y = 0;
        foreach (explode(', ', $input) as $command) {
            $turn = $command[0];
            $steps = (int) str_replace($turn, '', $command);

            if ($turn === 'R') {
                $direction++;
            } else {
                $direction--;
            }

            $direction = ($direction + 4) % 4;

            switch ($directions[$direction]) {
                case 'down':
                    $y += $steps;
                    break;
                case 'up':
                    $y -= $steps;
                    break;
                case 'left':
                    $x -= $steps;
                    break;
                case 'right':
                    $x += $steps;
                    break;
            }
        }

        return (string) (abs($x) + abs($y));
    }
    
    public function test1(): void
    {
        if ($this->solve('R2, L3') !== '5') {
            throw new RuntimeException('Test failed');
        }
    }

    public function test2(): void
    {
        if ($this->solve('R2, R2, R2') !== '2') {
            throw new RuntimeException('Test failed');
        }
    }

    public function test3(): void
    {
        if ($this->solve('R5, L5, R5, R3') !== '12') {
            throw new RuntimeException('Test failed');
        }
    }
}