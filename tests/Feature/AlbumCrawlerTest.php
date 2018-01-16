<?php

namespace Tests\Feature;

use App\Crawlers\AlbumCrawler;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumCrawlerTest extends TestCase
{

    /** @test */
    public function it_returns_an_album_information()
    {
        $album = (new AlbumCrawler())->crawl('https://www.metal-archives.com/albums/Megadeth/Last_Rites/4250');
        $this->assertEquals('March 9th, 1984', $album->releaseDate);
    }
}
