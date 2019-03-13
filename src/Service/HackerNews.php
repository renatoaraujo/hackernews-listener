<?php

namespace App\Service;

use Unirest\Request;

final class HackerNews
{
    private const BASE_URL = 'https://hacker-news.firebaseio.com/v0/';

    public function topStories(): array
    {
        $response = Request::get(self::BASE_URL . 'topstories.json', $headers = [], $parameters = null);
        return $response->body;
    }

    public function item(string $itemId): array
    {
        $response = Request::get(
            sprintf('%sitem/%s.json', self::BASE_URL, $itemId),
            $headers = [],
            $parameters = null
        );

        return (array) $response->body;
    }
}
