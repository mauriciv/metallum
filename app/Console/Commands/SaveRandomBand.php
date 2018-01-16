<?php

namespace App\Console\Commands;

use App\Band;
use App\Crawlers\RandomBandCrawler;
use Illuminate\Console\Command;

class SaveRandomBand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metallum:random-band';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Requests a random band and saves it to the database';

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
        $randomBand = (new RandomBandCrawler)->crawl();
        $bandInDB = Band::where('metallumId', $randomBand->metallumId)->first();
        if ($bandInDB === null) {
            echo "New band found\n";
            $randomBand->save();
        } else {
            echo "Existing band found\n";
            $bandInDB = $randomBand;
            $bandInDB->save();
        }
        $randomBand->saveLogoLocally();
        $randomBand->savePhotoLocally();
        return true;
    }
}
