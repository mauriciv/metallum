<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Band;
use App\Crawlers\AllAlbumsCrawler;
use App\Album;
use App\Crawlers\AlbumCrawler;
use App\Song;

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
        $bandId = null;
        if ($arg === null) {
            // Until most bands have all of their albums,
            // only get the bands that don't have any albums
            $bandId = Band::doesntHave('albums')->get()->random()->metallumId;
        } elseif (!is_numeric($arg)) {
            $bandId = Band::where('name', $arg)->firstOrFail()->metallumId;
        } else {
            $bandId = $arg;
        }
        $albums = (new AllAlbumsCrawler)->crawl($bandId);
        $albums->each(function ($album, $key) use ($bandId) {
            $savedAlbum = Album::updateOrCreate(['metallumId' => $album->metallumId], [
                'bandMetallumId' => $album->bandMetallumId,
                'name' => $album->name,
                'url' => $album->url,
                'artworkUrl' => $album->artworkUrl,
                'artworkLocalPath' => $album->artworkLocalPath,
                'type' => $album->type,
                'format' => $album->format,
                'label' => $album->label,
                'releaseDate' => $album->releaseDate
            ]);
            $savedAlbum->saveArtworkLocally();
            echo "Saved album: {$album->name} - Id: {$album->metallumId}\n";
            $album->songs->each(function ($song, $key) {
                Song::updateOrCreate(['metallumId' => $song->metallumId], [
                    'albumMetallumId' => $song->albumMetallumId,
                    'name' => $song->name,
                    'lyrics' => $song->lyrics,
                    'length' => $song->length,
                ]);
            });
        });
    }
}
