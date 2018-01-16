<?php

namespace App\Crawlers;

use Goutte\Client;

class AlbumCrawler
{

    public function crawl($url)
    {

        $crawler = (new Client())->request('GET', $url);
        $album = new \App\Album;
        $album->releaseDate = $crawler->filter('#album_info dl.float_left dd:nth-child(4)')->text();
        return $album;
    }

}
