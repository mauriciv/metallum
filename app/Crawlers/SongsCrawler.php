<?php

namespace App\Crawlers;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Song;

class SongsCrawler
{
    public function crawl($arg)
    {
        $crawler = null;
        if (get_class($arg) == 'Symfony\Component\DomCrawler\Crawler') {
            $crawler = $arg;
        } else {
            $crawler = (new Client())->request('GET', $arg);
        }
        $songs = collect();
        $albumMetallumId = explode('/', $crawler->filter('#member_box form div input:nth-child(7)')->attr('value'))[4];
        $crawler->filter('.display.table_lyrics tbody')->children()->each(function (Crawler $node) use ($songs, $albumMetallumId) {
            if ($node->attr('class') !== 'even' && $node->attr('class') !== 'odd') {
                return;
            }
            $song = new Song([
                'metallumId' => $node->filter('a')->attr('name'),
                'albumMetallumId' => $albumMetallumId,
                'name' => trim($node->filter('.wrapWords')->text())
             ]);
            if (!empty($node->filter('td:nth-child(3)')->text())) {
                $song->length = $node->filter('td:nth-child(3)')->text();
            }
            if (str_contains($node->text(), 'Show lyrics')) {
                $song->fetchLyrics();
            }
            $songs->push($song);
        });

        return $songs;
    }
}
