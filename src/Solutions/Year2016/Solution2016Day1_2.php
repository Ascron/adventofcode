<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2016;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2016/day/1#part2
 */
class Solution2016Day1_2 extends AbstractSolution implements SolutionInterface
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
        $visited = [
            '0,0'
        ];
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
                    for ($tempY = $y + 1; $tempY <= $y + $steps; $tempY++) {
                        $location = $x . ',' . $tempY;
                        if (in_array($location, $visited)) {
                            return (string) (abs($x) + abs($tempY));
                        } else {
                            $visited[] = $location;
                        }
                    }
                    $y += $steps;
                    break;
                case 'up':
                    for ($tempY = $y - 1; $tempY >= $y - $steps; $tempY--) {
                        $location = $x . ',' . $tempY;
                        if (in_array($location, $visited)) {
                            return (string) (abs($x) + abs($tempY));
                        } else {
                            $visited[] = $location;
                        }
                    }
                    $y -= $steps;
                    break;
                case 'left':
                    for ($tempX = $x - 1; $tempX >= $x - $steps; $tempX--) {
                        $location = $tempX . ',' . $y;
                        if (in_array($location, $visited)) {
                            return (string) (abs($tempX) + abs($y));
                        } else {
                            $visited[] = $location;
                        }
                    }
                    $x -= $steps;
                    break;
                case 'right':
                    for ($tempX = $x + 1; $tempX <= $x + $steps; $tempX++) {
                        $location = $tempX . ',' . $y;
                        if (in_array($location, $visited)) {
                            return (string) (abs($tempX) + abs($y));
                        } else {
                            $visited[] = $location;
                        }
                    }
                    $x += $steps;
                    break;
            }
        }

        return (string) (abs($x) + abs($y));
    }

    public function test1(): void
    {
        if ($this->solve('R8, R4, R4, R8') !== '4') {
            throw new RuntimeException('Test failed');
        }
    }
}