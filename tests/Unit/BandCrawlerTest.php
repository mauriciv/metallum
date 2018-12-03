<?php

namespace Tests\Feature;

use App\Crawlers\BandCrawler;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BandCrawlerTest extends TestCase
{
    /** @test */
    public function it_returns_a_band_information()
    {
        $band = (new BandCrawler)->crawl(138);

        $this->assertEquals($band->name, 'Megadeth');
        $this->assertEquals($band->metallumId, '138');
        $this->assertEquals($band->url, 'https://www.metal-archives.com/bands/Megadeth/138');
        $this->assertEquals($band->countryOfOrigin, 'United States');
        $this->assertEquals($band->location, 'Los Angeles, California');
        $this->assertEquals($band->status, 'Active');
        $this->assertEquals($band->formedIn, '1983');
        $this->assertEquals($band->genre, 'Speed/Thrash Metal (early/later), Heavy Metal/Rock (mid)');
        $this->assertEquals($band->lyricalThemes, 'Politics, War, History, Death, Religion, Hate, New World Order');
        $this->assertEquals($band->currentLabel, 'Tradecraft');
        $this->assertEquals($band->yearsActive, '1983 (as Fallen Angels), 1983-2002, 2004-present');
    }
}
