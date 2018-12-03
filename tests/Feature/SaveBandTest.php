<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Band;

class SaveBandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_band_is_saved_correctly()
    {
        Artisan::call('metallum:save-band', ['bandId' => '138']);
        $this->assertDatabaseHas('bands', [
            'metallumId' => 138,
            'url' => 'https://www.metal-archives.com/bands/Megadeth/138',
            'logoUrl' => 'https://www.metal-archives.com/images/1/3/8/138_logo.jpg?1040',
            'photoUrl' => 'https://www.metal-archives.com/images/1/3/8/138_photo.jpg?4147',
            'countryOfOrigin' => 'United States',
            'name' => 'Megadeth',
            'location' => 'Los Angeles, California',
            'status' => 'Active',
            'formedIn' => '1983',
            'genre' => 'Speed/Thrash Metal (early/later), Heavy Metal/Rock (mid)',
            'lyricalThemes' => 'Politics, War, History, Death, Religion, Hate, New World Order',
            'currentLabel' => 'Tradecraft',
            'yearsActive' => '1983 (as Fallen Angels), 1983-2002, 2004-present',
        ]);
    }

    /** @test */
    public function a_band_is_only_saved_once()
    {
        $this->assertSame(0, Band::where('metallumId', '138')->count());
        Artisan::call('metallum:save-band', ['bandId' => '138']);
        $this->assertSame(1, Band::where('metallumId', '138')->count());
        Artisan::call('metallum:save-band', ['bandId' => '138']);
        $this->assertSame(1, Band::where('metallumId', '138')->count());
    }
}
