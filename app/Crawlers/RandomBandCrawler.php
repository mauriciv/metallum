<?php

namespace App\Crawlers;

use Goutte\Client;

class RandomBandCrawler
{
    protected $client;

    function __construct()
    {
        $this->client = new Client();
    }

    public function crawl()
    {
        return (new BandCrawler())->crawl('https://www.metal-archives.com/band/random');
    }
}
