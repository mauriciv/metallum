<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $guarded = [];

    public function album()
    {
        return $this->belongsTo(Album::class, 'albumMetallumId', 'metallumId');
    }

    public function fetchLyrics()
    {
        $lyrics = file_get_contents("https://www.metal-archives.com/release/ajax-view-lyrics/id/{$this->metallumId}");
        if ($lyrics === false) {
            return;
        }
        if (str_contains($lyrics, 'lyrics not available')) {
            return;
        }
        $this->lyrics = str_replace(['<br />', "\t"], '', $lyrics);
    }
}
