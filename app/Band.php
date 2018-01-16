<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    protected $guarded = [];

    public function albums()
    {
        return $this->hasMany(Album::class, 'bandMetallumId', 'metallumId');
    }

    public function saveLogoLocally()
    {
        if ($this->logoUrl === null) {
            return;
        }
        $logo = file_get_contents($this->logoUrl);
        $explodedUrl = explode('.', str_before($this->logoUrl, '?'));
        $fileFormat = end($explodedUrl); // end() expects an array variable, not a function returning an array
        $this->update([
            'logoLocalPath' => "{$this->metallumId}/{$this->metallumId}-logo.$fileFormat"
        ]);
        \Storage::put('public/' . $this->fresh()->logoLocalPath, $logo);
    }

    public function savePhotoLocally()
    {
        if ($this->photoUrl === null) {
            return;
        }
        $photo = file_get_contents($this->photoUrl);
        $explodedUrl = explode('.', str_before($this->photoUrl, '?'));
        $fileFormat = end($explodedUrl);
        $this->update([
            'photoLocalPath' => "{$this->metallumId}/{$this->metallumId}-photo.$fileFormat"
        ]);
        \Storage::put('public/' . $this->fresh()->photoLocalPath, $photo);
    }
}
