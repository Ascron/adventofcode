<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2023;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2023/day/2
 */
class Solution2023Day2_1 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $result = 0;

        foreach (Lines::fromInput($input) as $line) {
            [$gameName, $gameMoves] = explode(': ', $line);
            $ballCounts = $this->parseGame($gameMoves);
            if ($this->isGamePossible($ballCounts)) {
                [,$gameNumber] = explode(' ', $gameName);
                $result += (int) $gameNumber;
            }
        }

        return (string) $result;
    }

    private function parseGame(string $gameMoves): array
    {
        $result = [];
        foreach (explode('; ', $gameMoves) as $move) {
            foreach (explode(', ', $move) as $movePart) {
                [$number, $color] = explode(' ', $movePart);
                $result[$color] ??= (int) $number;
                $result[$color] = max($result[$color], (int) $number);
            }
        }
        return $result;
    }

    private function isGamePossible(array $data): bool
    {
        // only 12 red cubes, 13 green cubes, and 14 blue cubes
        $possibleSet = [
            'red' => 12,
            'green' => 13,
            'blue' => 14,
        ];

        foreach ($possibleSet as $key => $value) {
            if (($data[$key] ?? 0) > $value) {
                return false;
            }
        }

        return true;
    }
    
    public function testExample(): void
    {
        $input = <<<INPUT
            Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
            Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
            Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
            Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
            Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
            INPUT;

        if ($this->solve($input) !== '8') {
            throw new RuntimeException('Test failed');
        } 
    }
}