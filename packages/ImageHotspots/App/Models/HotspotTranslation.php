<?php


namespace Packages\ImageHotspots\App\Models;


use Illuminate\Database\Eloquent\Model;

class HotspotTranslation extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'body',
    ];
}
