<?php


namespace Packages\ImageHotspots\App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

class Hotspot extends Model
{
    use SoftDeletes;
    use Translatable;
    use SortableTrait;

    public $fillable = [
        'coordinates',
        'images',
        'images_detail',
        'priority'
    ];

    public $translatedAttributes = [
        'title',
        'subtitle',
        'body',
    ];

    public function setCoordinatesAttribute($value)
    {
        $this->attributes['coordinates'] = json_encode($value);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function setImagesDetailAttribute($value)
    {
        $this->attributes['images_detail'] = json_encode($value);
    }

    public function getCoordinatesAttribute($value)
    {
        $coordinates = json_decode($value, true);

        return $coordinates ?? ['x'=>0, 'y'=>0];
    }

    public function getImagesAttribute($value)
    {
        $images_array = json_decode($value, true);

        return $images_array ?? [];
    }

    public function getImagesDetailAttribute($value)
    {
        $images_array = json_decode($value, true);

        return $images_array ?? [];
    }

    public function hotspotImage()
    {
        return $this->belongsTo(HotspotImage::class);
    }
}
