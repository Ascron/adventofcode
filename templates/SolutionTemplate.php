<?php

declare(strict_types=1);

$template = <<<'EOD'
<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Solutions\Year{{year}};

use Ascron\Adventofcode\Solutions\AbstractSolution;
use Ascron\Adventofcode\Solutions\SolutionInterface;
use RuntimeException;

/**
 * {{puzzleDescription}}
 */
class {{className}} extends AbstractSolution implements SolutionInterface
{
    public function solve(string $input): string
    {
        $input = explode("\n", $input);
        $result = '';

        foreach ($input as $line) {
            // Do something with $line
        }

        return (string) $result;
    }
    
    public function testExample(): void
    {
        if ($this->solve('test_input') !== 'test_output') {
            throw new RuntimeException('Test failed');
        } 
    }
}
EOD;

return $template;