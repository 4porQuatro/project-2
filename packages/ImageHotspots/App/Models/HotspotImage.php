<?php


namespace Packages\ImageHotspots\App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotspotImage extends Model
{
    use SoftDeletes;

    public $fillable = [
        'image_path',
    ];

    public function hotspots()
    {
        return $this->hasMany(Hotspot::class);
    }
}
