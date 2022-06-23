<?php

namespace Packages\Store\app\Models;

use App\Models\ExternalReference;
use Packages\Store\database\factories\AttributeFactory;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Attribute extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    const SWATCH_TYPE_OPTIONS = [
        'color'
    ];

    public $fillable = [
        'admin_title',
        'unique_per_product',
        'priority',
        'swatch_type'
    ];

    public $translatedAttributes = [
        'title',
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
        'unique_per_product'=>'boolean',
        'priority'=>'integer',
    ];

    protected static function newFactory()
    {
        return AttributeFactory::new();
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function families()
    {
        return $this->belongsToMany(AttributeFamily::class);
    }

    public function externalReference()
    {
        return $this->morphOne(ExternalReference::class, 'external_referenceable');
    }
}
