<?php

namespace App\Crawlers;

use App\Album;
use Goutte\Client;

class AlbumCrawler
{
    public function crawl($url)
    {
        $crawler = (new Client())->request('GET', $url);
        $album = new Album;
        $album->url = $url;

        if ($crawler->filter('.album_img a img')->count() > 0) {
            $album->artworkUrl = $crawler->filter('.album_img a img')->attr('src');
        }

        $album->bandMetallumId = explode('/', $crawler->filter('.band_name a')->attr('href'))[5];
        $album->type = $crawler->filter('#album_info dl.float_left dd:nth-child(2)')->text();
        $album->releaseDate = $crawler->filter('#album_info dl.float_left dd:nth-child(4)')->text();
        $album->metallumId = explode('/', $crawler->filter('#member_box form div input:nth-child(7)')->attr('value'))[4];
        $album->name = $crawler->filter('.album_name a')->text();
        $album->label = $crawler->filter('#album_info dl.float_right dd:nth-child(2)')->text();
        $album->format = $crawler->filter('#album_info dl.float_right dd:nth-child(4)')->text();

        $album->songs = (new SongsCrawler)->crawl($crawler);

        return $album;
    }
}
