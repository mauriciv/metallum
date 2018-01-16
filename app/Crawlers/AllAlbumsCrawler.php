<?php

namespace App\Crawlers;

use App\Album;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class AllAlbumsCrawler
{
    public function crawl($bandMetallumId)
    {
        echo $bandMetallumId."\n";
        $crawler = (new Client())
            ->request('GET', "https://www.metal-archives.com/band/discography/id/$bandMetallumId/tab/all");
        if (strpos($crawler->filter('tbody')->html(), 'Nothing entered yet') !== false) {
            exit('The band has no albums.' . "\n");
        }
        $releases = collect();
        $crawler->filter('tbody')->children()->each(function (Crawler $node) use ($releases, $bandMetallumId) {
            $releases->push(new Album([
                'bandMetallumId' => $bandMetallumId,
                'metallumId' => explode('/', $node->filter('td:nth-child(1) a')->attr('href'))[6],
                'name' => $node->filter('td:nth-child(1) a')->text(),
                'url' => $node->filter('td:nth-child(1) a')->attr('href'),
                'type' => $node->filter('td:nth-child(2)')->text(),
            ]));
        });
        return $releases;
    }
}
