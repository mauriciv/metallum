<?php

namespace App\Crawlers;

use App\Album;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Band;

class AllAlbumsCrawler
{
    public function crawl($bandMetallumId)
    {
        $band = Band::where('metallumId', $bandMetallumId)->firstOrFail();
        echo "Band name: {$band->name} - Id: $bandMetallumId\n";
        $crawler = (new Client())
            ->request('GET', "https://www.metal-archives.com/band/discography/id/$bandMetallumId/tab/all");
        if (strpos($crawler->filter('tbody')->html(), 'Nothing entered yet') !== false) {
            exit('The band has no albums.' . "\n");
        }
        $releases = collect();
        $crawler->filter('tbody')->children()->each(function (Crawler $node) use ($releases) {
            $releases->push((new AlbumCrawler)->crawl($node->filter('td:nth-child(1) a')->attr('href')));
            // 'url' => $node->filter('td:nth-child(1) a')->attr('href'),
        });
        return $releases;
    }
}
