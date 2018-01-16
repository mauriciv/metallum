<?php

namespace App\Crawlers;

use Goutte\Client;

class BandCrawler
{

    public function crawl($url)
    {
        if (is_numeric($url)) {
            $url = "https://www.metal-archives.com/band/view/id/$url";
        }
        $crawler = (new Client())->request('GET', $url);
        $band = new \App\Band();
        $band->name = $crawler->filter('h1.band_name a')->text();
        $band->metallumId = explode('/', $crawler->filter('h1.band_name a')->attr('href'))[5];
        echo $band->metallumId . "\n";
        $band->url = $crawler->filter('h1.band_name a')->attr('href');

        if ($crawler->filter('#band_sidebar .band_name_img a')->count() > 0) {
            $band->logoUrl = $crawler->filter('#band_sidebar .band_name_img a')->attr('href');
        }

        if ($crawler->filter('#band_sidebar .band_img a')->count() > 0) {
            $band->photoUrl = $crawler->filter('#band_sidebar .band_img a')->attr('href');
        }

        $statsNode = $crawler->filter('#band_stats');
        $band->countryOfOrigin = $statsNode->filter('dl.float_left dd:nth-child(2)')->text();
        $band->location = $statsNode->filter('dl.float_left dd:nth-child(4)')->text();
        $band->status = $statsNode->filter('dl.float_left dd:nth-child(6)')->text();
        $band->formedIn = $statsNode->filter('dl.float_left dd:nth-child(8)')->text();
        $band->genre = $statsNode->filter('dl.float_right dd:nth-child(2)')->text();
        $band->lyricalThemes = $statsNode->filter('dl.float_right dd:nth-child(4)')->text();
        $band->currentLabel = $statsNode->filter('dl.float_right dd:nth-child(6)')->text();
        $band->yearsActive = trim(preg_replace('/\s+/', ' ', $statsNode->filter('dl:nth-child(3) dd')->text()));
        return $band;
    }

}
