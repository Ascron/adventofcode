<?php

declare(strict_types=1);

namespace Ascron\Adventofcode\Utils\AdventApi;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class AdventApi
{
    private Client $guzzleClient;

    public function __construct(string $cookie)
    {
        $this->guzzleClient = new Client([
            'base_uri' => 'https://adventofcode.com/',
            'headers' => [
                'User-Agent' => 'github.com/Ascron/adventofcode by ascronz@gmail.com'
            ],
            'cookies' => CookieJar::fromArray(['session' => $cookie], 'adventofcode.com'),
        ]);
    }

    public function getInput(int $year, int $day): string
    {
        $response = $this->guzzleClient->request('GET', "/{$year}/day/{$day}/input");
        $response->getStatusCode() === 400 && throw new OutdatedCookieException();
        return (string) $response->getBody();
    }

    public function sendResult(int $year, int $day, int $part, string $result): void
    {
        $response = $this->guzzleClient->request('POST', "/{$year}/day/{$day}/answer", [
            'form_params' => [
                'level' => $part,
                'answer' => $result,
            ],
        ]);

        $response->getStatusCode() === 302 && throw new OutdatedCookieException();

        $responseBody = (string) $response->getBody();
        if (str_contains($responseBody, 'That\'s the right answer!')) {
            echo "Success!\n";
        } elseif (str_contains($responseBody, 'That\'s not the right answer')) {
            echo "Wrong answer\n";
        } elseif (str_contains($responseBody, 'You don\'t seem to be solving the right level')) {
            echo "You\'re sending result of wrong levelt\n";
        } elseif (str_contains($responseBody, 'You gave an answer too recently')) {
            echo "Too fast\n";
        } else {
            echo "Unknown response\n";
        }
    }
}