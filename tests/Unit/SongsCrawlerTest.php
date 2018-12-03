<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Crawlers\SongsCrawler;

class SongsCrawlerTest extends TestCase
{
    /** @test */
    public function it_returns_songs_from_an_album()
    {
        $songs = (new SongsCrawler())->crawl('https://www.metal-archives.com/albums/Megadeth/Last_Rites/4250');
        $firstSong = $songs[0];
        $this->assertEquals('38701A', $firstSong->metallumId);
        $this->assertEquals('4250', $firstSong->albumMetallumId);
        $this->assertEquals('Last Rites / Loved to Deth', $firstSong->name);
        // $this->assertEquals('4250', $firstSong->lyrics);
        $this->assertContains("Your body's empty now, as I hold you", $firstSong->lyrics);
        $this->assertEquals('04:16', $firstSong->length);
    }
}
