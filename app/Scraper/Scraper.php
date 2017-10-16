<?php

namespace App\Scraper;

use Goutte\Client;

class Scraper
{

    protected $client;

    function __construct()
    {
        $this->client = new Client();
    }

    function main()
    {
        $band = new \StdClass();
        $crawler = $this->client->request('GET', 'https://www.metal-archives.com/bands/Megadeth/138');
        $band->name = $crawler->filter('h1.band_name a')->text();
        $statsNode = $crawler->filter('#band_stats');
        $band->countryOfOrigin = $statsNode->filter('dl.float_left dd:nth-child(2)')->text();
        $band->location = $statsNode->filter('dl.float_left dd:nth-child(4)')->text();
        $band->status = $statsNode->filter('dl.float_left dd:nth-child(6)')->text();
        $band->formedIn = $statsNode->filter('dl.float_left dd:nth-child(8)')->text();
        return $band;
//        dd($band);
    }

}
