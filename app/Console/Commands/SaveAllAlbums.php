<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Band;
use App\Crawlers\AllAlbumsCrawler;
use App\Album;

class SaveAllAlbums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metallum:save-albums {bandNameOrId?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $arg = $this->argument('bandNameOrId');
        $albums = collect();
        $bandId = null;
        if ($arg === null) {
            $bandId = Band::all()->random()->metallumId;
        } elseif (!is_numeric($arg)) {
            $bandId = Band::where('name', $arg)->firstOrFail()->metallumId;
        }
        $albums = (new AllAlbumsCrawler)->crawl($bandId);
        $albums->each(function ($album, $key) use ($bandId) {
            $albumInDB = Album::where('metallumId', $album->metallumId)->first();
            if ($albumInDB === null) {
                $album->save();
            } else {
                $albumInDB = $album;
                $albumInDB->save();
            }
        });
    }
}
