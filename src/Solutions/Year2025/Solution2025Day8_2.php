<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year2025;

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;
use Ascron\Adventofcode\Utils\Lines;

/**
 * @see https://adventofcode.com/2025/day/8#part2
 */
class Solution2025Day8_2 extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $boxes = [];

        foreach (Lines::fromInput($input) as $line) {
            [$x, $y, $z] = explode(',', $line);
            $boxes[] = [(int)$x, (int)$y, (int)$z];
        }

        $gridTable = [];
        foreach ($boxes as $index => [$x, $y, $z]) {
            for ($i = $index + 1, $c = count($boxes); $i < $c; $i++) {
                [$x2, $y2, $z2] = $boxes[$i];
                $gridTable[$index . '-' . $i] = ($x - $x2) ** 2 + ($y - $y2) ** 2 + ($z - $z2) ** 2;
            }
        }

        $grids = [];
        $gridRelation = [];
        $gridIndex = 0;

        while (true) {
            $minDistance = min($gridTable);
            $keys = array_keys($gridTable, $minDistance);
            foreach ($keys as $key) {
                unset($gridTable[$key]);
                [$box1, $box2] = explode('-', $key);
                $box1 = (int) $box1;
                $box2 = (int) $box2;
                $existingGrid1 = $gridRelation[$box1] ?? null;
                $existingGrid2 = $gridRelation[$box2] ?? null;
                if ($existingGrid1 !== null && $existingGrid2 !== null) {
                    if ($existingGrid1 !== $existingGrid2) {
                        if (count($grids[$existingGrid1]) >= count($grids[$existingGrid2])) {
                            foreach ($grids[$existingGrid2] as $box) {
                                $grids[$existingGrid1][] = $box;
                                $gridRelation[$box] = $existingGrid1;
                            }
                            unset($grids[$existingGrid2]);
                            if (count($grids[$existingGrid1]) === count($boxes)) {
                                return (string) ($boxes[$box1][0] * $boxes[$box2][0]);
                            }
                        } else {
                            foreach ($grids[$existingGrid1] as $box) {
                                $grids[$existingGrid2][] = $box;
                                $gridRelation[$box] = $existingGrid2;
                            }
                            unset($grids[$existingGrid1]);
                            if (count($grids[$existingGrid2]) === count($boxes)) {
                                return (string) ($boxes[$box1][0] * $boxes[$box2][0]);
                            }
                        }
                    }
                } elseif ($existingGrid1 === null && $existingGrid2 === null) {
                    $grids[$gridIndex] = [$box1, $box2];
                    $gridRelation[$box1] = $gridIndex;
                    $gridRelation[$box2] = $gridIndex;
                    $gridIndex++;
                } elseif ($existingGrid1 !== null) {
                    $grids[$existingGrid1][] = $box2;
                    $gridRelation[$box2] = $existingGrid1;
                    if (count($grids[$existingGrid1]) === count($boxes)) {
                        return (string) ($boxes[$box1][0] * $boxes[$box2][0]);
                    }
                } elseif ($existingGrid2 !== null) {
                    $grids[$existingGrid2][] = $box1;
                    $gridRelation[$box1] = $existingGrid2;
                    if (count($grids[$existingGrid2]) === count($boxes)) {
                        return (string) ($boxes[$box1][0] * $boxes[$box2][0]);
                    }
                }
            }
        }
    }

    public function test1(): void
    {
        $input = <<<AOC
            162,817,812
            57,618,57
            906,360,560
            592,479,940
            352,342,300
            466,668,158
            542,29,236
            431,825,988
            739,650,466
            52,470,668
            216,146,977
            819,987,18
            117,168,530
            805,96,715
            346,949,466
            970,615,88
            941,993,340
            862,61,35
            984,92,344
            425,690,689
            AOC;

        $output = '25272';

        $testResult = $this->solve($input);

        if ($testResult !== $output) {
            throw new RuntimeException('Test failed with result ' . $testResult);
        }
    }


}