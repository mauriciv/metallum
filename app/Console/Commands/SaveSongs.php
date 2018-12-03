<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Album;
use App\Crawlers\SongsCrawler;
use App\Song;

class SaveSongs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metallum:save-songs {albumNameOrId?}';

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
        $arg = $this->argument('albumNameOrId');
        $albumUrl = null;
        if ($arg === null) {
            $albumUrl = Album::all()->random()->url;
        } elseif (!is_numeric($arg)) {
            $albumUrl = Album::where('name', $arg)->firstOrFail()->url;
        } else {
            $albumUrl = Album::where('metallumId', $arg)->firstOrFail()->url;
        }
        $songs = (new SongsCrawler)->crawl($albumUrl);
        $songs->each(function ($song, $key) {
            $song = Song::updateOrCreate(['metallumId' => $song->metallumId], [
                    'albumMetallumId' => $song->albumMetallumId,
                    'name' => $song->name,
                    'lyrics' => $song->lyrics,
                    'length' => $song->length,
            ]);
            echo "Saved song: {$song->metallumId} - {$song->name}\n";
        });
    }
}
