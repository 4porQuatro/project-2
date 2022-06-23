<?php

namespace Packages\Store\app\Models;

use App\Models\ExternalReference;
use Packages\Store\database\factories\AttributeOptionFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class AttributeOption extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    public $fillable = [
        'priority',
        'swatch_value',
        'images',
    ];

    public $translatedAttributes = [
        'title',
        'body',
    ];

    /**
     * The sortable library data for this model
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'priority'=>'integer',
        'attribute_id'=>'integer',
    ];

    protected static function newFactory()
    {
        return AttributeOptionFactory::new();
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        $images_array = json_decode($value, true);
        return $images_array ?? [];
    }

    public function externalReference()
    {
        return $this->morphOne(ExternalReference::class, 'external_referenceable');
    }
}
