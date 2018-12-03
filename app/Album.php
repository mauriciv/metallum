<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = [];

    public function songs()
    {
        return $this->hasMany(Song::class, 'albumMetallumId', 'metallumId');
    }

    public function band()
    {
        return $this->belongsTo(Band::class, 'bandMetallumId', 'metallumId');
    }

    public function saveArtworkLocally()
    {
        if ($this->artworkUrl === null) {
            return;
        }
        $artwork = file_get_contents($this->artworkUrl);
        if ($artwork === false) {
            return;
        }
        $explodedUrl = explode('.', str_before($this->artworkUrl, '?'));
        $fileFormat = end($explodedUrl); // end() expects an array variable, not a function returning an array
        $this->update([
            'artworkLocalPath' => "{$this->bandMetallumId}/{$this->metallumId}-artwork.$fileFormat"
        ]);
        $album = $this->fresh();
        if ($album !== null) {
            \Storage::put('public/' . $album->artworkLocalPath, $artwork);
        }
    }
}
