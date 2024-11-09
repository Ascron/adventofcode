<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

use ReflectionClass;
use RuntimeException;
use Throwable;

class SolutionRunner
{
    public function __construct(
        private readonly LocalDataStorage $storage
    ) {
    }

    public function runSolution(int $year, int $day, int $part): string
    {
        if (!$this->storage->inputExists($year, $day))  {
            throw new RuntimeException("Input for year {$year} day {$day} is missing");
        }

        $input = $this->storage->getInput($year, $day);

        $class = $this->getClass($year, $day, $part);
        $solution = new $class();
        $result = $solution->solve($input);
        echo "Result:\n====\n{$result}\n====\n";
        return $result;
    }

    public function runTests(int $year, int $day, int $part): bool
    {
        $class = $this->getClass($year, $day, $part);
        $solution = new $class();

        $reflection = new ReflectionClass($solution);
        $methods = $reflection->getMethods();
        $testMethods = [];

        foreach ($methods as $method) {
            if (str_starts_with($method->getName(), 'test')) {
                $testMethods[] = $method->getName();
            }
        }

        $result = true;
        foreach ($testMethods as $testMethod) {
            try {
                $solution->$testMethod();
                echo "{$testMethod} passed\n";
            } catch (Throwable $throwable) {
                $result = false;
                echo "{$testMethod} failed with message: {$throwable->getMessage()}\n";
            }
        }

        return $result;
    }

    public function getClass(int $year, int $day, int $part): string
    {
        return "Ascron\\Adventofcode\\Solutions\\Year{$year}\\Solution{$year}Day{$day}_{$part}";
    }
}