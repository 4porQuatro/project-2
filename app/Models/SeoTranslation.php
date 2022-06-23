<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoTranslation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'keywords',
        'images',
        'geo_placename',
        'micro_data',
        'scripts'
    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value);
    }
}
