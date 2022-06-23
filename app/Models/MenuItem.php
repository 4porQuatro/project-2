<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuItem extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    public $translatedAttributes = [
        'name',
        'url',
        'active'
    ];

    public $fillable = [
        'menu_id',
        'priority',
        'parent_id',
        'itemable_id',
        'itemable_type',
        'images'
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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'path'
    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        $images_array = json_decode($value, true);
        return $images_array ?? [];
    }

    public function getPathAttribute()
    {
        return $this->itemable ? $this->itemable->path() : $this->path();
    }

    public function path()
    {
        return $this->url;
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function activeChildrens()
    {
        return $this->childrens()->active();
    }

    public function scopeWithoutParent($q)
    {
        return $q->whereNull('parent_id');
    }

    public function scopeActive($q)
    {
        return $q->whereTranslation('active', true, app()->getLocale());
    }

    /**
     * Get the parent itemable model (the model responsible to give this item a path).
     */
    public function itemable()
    {
        return $this->morphTo();
    }
}
