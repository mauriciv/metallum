<?php

namespace Tests\Unit;

use App\Crawlers\AllAlbumsCrawler;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AllAlbumsCrawlerTest extends TestCase
{
    public function it_returns_all_the_albums_for_a_band()
    {
        $albums = (new AllAlbumsCrawler())->crawl(138);

        $this->assertArraySubset([[
            "metallumId" => "4250",
            "name" => "Last Rites",
            "url" => "https://www.metal-archives.com/albums/Megadeth/Last_Rites/4250",
            "type" => "Demo",
            "year" => "1984"
        ]], $albums->toArray());
    }
}
