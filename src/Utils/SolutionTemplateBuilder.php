<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils;

class SolutionTemplateBuilder
{
    public function __construct(
        private readonly string $solutionDir,
        private readonly string $templateDir,
    ) {
    }

    public function build(
        string $templateName,
        int $year,
        int $day,
        int $part
    ): void {
        $className = $this->getClassName($year, $day, $part);
        $solutionFilePath = $this->getSolutionFilePath($year, $className);

        if (file_exists($solutionFilePath)) {
            return;
        }

        $this->prepareSolutionFolder($year);

        $code = $this->render(
            $templateName,
            [
                'year' => $year,
                'className' => $className,
                'puzzleDescription' => $this->preparePuzzleDescription($year, $day, $part),
            ]
        );

        file_put_contents($solutionFilePath, $code);
    }

    private function render(string $templateName, array $data): string
    {
        $template = require "{$this->templateDir}/{$templateName}";
        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', (string) $value, $template);
        }

        return $template;
    }

    private function prepareSolutionFolder(int $year)
    {
        $solutionDir = $this->getYearDirPath($year);

        if (!file_exists($solutionDir)) {
            mkdir($solutionDir);
        }
    }

    private function getYearDirPath(int $year): string
    {
        return "{$this->solutionDir}/Year{$year}";
    }

    private function getSolutionFilePath(int $year, string $className): string
    {
        return $this->getYearDirPath($year) . "/{$className}.php";
    }

    private function getClassName(int $year, int $day, int $part): string
    {
        return "Solution{$year}Day{$day}_{$part}";
    }

    private function preparePuzzleDescription(int $year, int $day, int $part): string
    {
        return "@see https://adventofcode.com/{$year}/day/{$day}" . ($part > 1 ? "#part{$part}" : '');
    }
}