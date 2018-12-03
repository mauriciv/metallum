<?php

namespace App\Console\Commands;

use App\Band;
use App\Crawlers\RandomBandCrawler;
use Illuminate\Console\Command;
use App\Crawlers\BandCrawler;

class SaveBand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metallum:save-band {bandId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests a band and saves it to the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bandId = $this->argument('bandId');
        $band = null;
        if ($bandId == null) {
            $band = (new RandomBandCrawler)->crawl();
        } else {
            $band = (new BandCrawler)->crawl($bandId);
        }
        $band = Band::updateOrCreate(['metallumId' => $band->metallumId], [
            'url' => $band->url,
            'logoUrl' => $band->logoUrl,
            'photoUrl' => $band->photoUrl,
            'countryOfOrigin' => $band->countryOfOrigin,
            'name' => $band->name,
            'location' => $band->location,
            'status' => $band->status,
            'formedIn' => $band->formedIn,
            'genre' => $band->genre,
            'lyricalThemes' => $band->lyricalThemes,
            'currentLabel' => $band->currentLabel,
            'yearsActive' => $band->yearsActive,
        ]);
        echo "Saved band: {$band->metallumId} - {$band->name}\n";
        $band->saveLogoLocally();
        $band->savePhotoLocally();
    }
}
