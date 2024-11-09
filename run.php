<?php

require 'vendor/autoload.php';

/**
 * New year starts with december, so we have to go back 11 months to get the current year
 */
$currentAdventYear = date('Y',  strtotime('-11 month'));

$cookieStorage = new \Ascron\Adventofcode\Utils\CookieStorage(
    __DIR__ . "/.cookie",
);

$templateBuilder = new \Ascron\Adventofcode\Utils\SolutionTemplateBuilder(
    __DIR__ . "/src/Solutions",
    __DIR__ . "/templates",
);

$localDataStorage = new \Ascron\Adventofcode\Utils\LocalDataStorage(__DIR__ . '/data');

switch ($argv[1]) {
    case 'prepare':
        $puzzle = $argv[2];
        [$day, $part] = explode('.', $puzzle);
        $year = (int) ($argv[3] ?? $currentAdventYear);

        if (!$cookieStorage->exists() && !$localDataStorage->inputExists($year, (int) $day)) {
            echo 'Please provide your session cookie' . PHP_EOL;
            $cookie = trim(fgets(STDIN));
            $cookieStorage->store($cookie);
        } else {
            $cookie = $cookieStorage->get();
        }

        $api = new \Ascron\Adventofcode\Utils\AdventApi\AdventApi($cookie);
        $dataProvider = new \Ascron\Adventofcode\Utils\DataProvider($api, $localDataStorage);
        try {
            $dataProvider->getInput($year, (int) $day);
        } catch (\Ascron\Adventofcode\Utils\AdventApi\OutdatedCookieException) {
            $cookieStorage->delete();
            echo 'Cookie is outdated, please provide a new one' . PHP_EOL;
        }

        $templateBuilder->build(
            'SolutionTemplate.php',
            $year,
            (int) $day,
            (int) $part
        );
        break;
    case 'test':
        $puzzle = $argv[2];
        [$day, $part] = explode('.', $puzzle);
        $year = (int) ($argv[3] ?? $currentAdventYear);

        $solutionRunner = new \Ascron\Adventofcode\Utils\SolutionRunner($localDataStorage);
        if ($solutionRunner->runTests($year, (int) $day, (int) $part)) {
            echo 'All tests passed' . PHP_EOL;
            $solutionRunner->runSolution($year, (int) $day, (int) $part);
        }
        break;
    case 'send':
        if (!$cookieStorage->exists()) {
            echo 'Please provide your session cookie' . PHP_EOL;
            $cookie = trim(fgets(STDIN));
            $cookieStorage->store($cookie);
        } else {
            $cookie = $cookieStorage->get();
        }

        $puzzle = $argv[2];
        [$day, $part] = explode('.', $puzzle);
        $year = (int) ($argv[3] ?? $currentAdventYear);

        $solutionRunner = new \Ascron\Adventofcode\Utils\SolutionRunner($localDataStorage);
        $result = $solutionRunner->runSolution($year, (int) $day, (int) $part);
        $api = new \Ascron\Adventofcode\Utils\AdventApi\AdventApi($cookie);
        try {
            $api->sendResult($year, $day, $part, $result);
        } catch (\Ascron\Adventofcode\Utils\AdventApi\OutdatedCookieException) {
            $cookieStorage->delete();
            echo 'Cookie is outdated, please provide a new one' . PHP_EOL;
        }

        break;
}