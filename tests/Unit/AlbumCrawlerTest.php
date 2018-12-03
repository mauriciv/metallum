<?php

namespace Tests\Unit;

use App\Crawlers\AlbumCrawler;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlbumCrawlerTest extends TestCase
{

    /** @test */
    public function it_returns_an_album_information()
    {
        $album = (new AlbumCrawler())->crawl('https://www.metal-archives.com/albums/Megadeth/Last_Rites/4250');
        $this->assertEquals('https://www.metal-archives.com/images/4/2/5/0/4250.jpg', $album->artworkUrl);
        $this->assertEquals('138', $album->bandMetallumId);
        $this->assertEquals('4250', $album->metallumId);
        $this->assertEquals('Last Rites', $album->name);
        $this->assertEquals('https://www.metal-archives.com/albums/Megadeth/Last_Rites/4250', $album->url);
        $this->assertEquals('Demo', $album->type);
        $this->assertEquals('March 9th, 1984', $album->releaseDate);
        $this->assertEquals('Demo', $album->type);
        $this->assertEquals('Independent', $album->label);
        $this->assertEquals('Cassette', $album->format);
    }
}
