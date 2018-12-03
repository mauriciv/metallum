<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use App\Band;

class SaveAllAlbumsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_albums_are_saved_with_their_songs()
    {
        Band::create([
            'metallumId' => 3540442855,
            'name' => 'Misfortune',
            'location' => 'Venice, Veneto',
            'status' => 'Active',
            'formedIn' => '2017',
            'genre' => 'Doom Metal',
            'lyricalThemes' => 'N/A',
            'currentLabel' => 'Unsigned/independent',
            'yearsActive' => '2017-present',
            'url' => 'https://www.metal-archives.com/albums/Misfortune/Abjurer%27s_Yoke/724401',
            'countryOfOrigin' => 'Italy',
        ]);
        Artisan::call('metallum:save-albums', ['bandNameOrId' => '3540442855']);
        $this->assertDatabaseHas('albums', [
            'metallumId' => 724401,
            'bandMetallumId' => 3540442855,
            'name' => "Abjurer's Yoke",
            'url' => 'https://www.metal-archives.com/albums/Misfortune/Abjurer%27s_Yoke/724401',
            'artworkUrl' => 'https://www.metal-archives.com/images/7/2/4/4/724401.jpg?4945',
            'type' => 'Demo',
            'format' => 'CD',
            'label' => 'Independent',
            'releaseDate' => 'May 21st, 2018',
        ]);
        $this->assertDatabaseHas('songs', [
            'metallumId' => 4644231,
            'albumMetallumId' => 724401,
            'name' => 'Called by the Toll of Hell',
            'lyrics' => null,
            'length' => '08:01',
        ]);
    }
}
