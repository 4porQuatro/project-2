<?php

namespace App\Models;

use App\Classes\Front\Url\UrlGenerator;
use App\Interfaces\ModelSettignable;
use App\Interfaces\Pathable;
use App\Interfaces\Seoable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Page extends Model implements Sortable, Pathable, ModelSettignable, Seoable
{
    use Translatable;
    use SortableTrait;
    use HasFactory;

    public $translatedAttributes = [
        'name',
        'slug',
        'active',
    ];

    protected $fillable = [
        'priority',
        'is_homepage',
        'active',
        'layout_id'
    ];

    public $with = [
        'translations'
    ];

    protected $casts = [
        'is_homepage'=>'boolean',
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

    public static function getReadableName($plural = false)
    {
        return $plural ? 'Páginas' : 'Página';

    }
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    public function pageable()
    {
        return $this->morphTo();
    }

    public function getLayout()
    {
        return !empty($this->layout_id) ? $this->layout : Layout::default()->first();
    }

    public function path()
    {
        $base_url = UrlGenerator::get();

        $pageable_prefix = $this->pageable && !$this->is_homepage ? $this->pageable->getPrefix() : '';

        return $base_url.$pageable_prefix.$this->slug;
    }

    public function getPathables()
    {
        return $this->all()->pluck('name', 'id')->toArray();
    }

    public function previewPath()
    {
        return $this->path();
    }

    public static function getModelSettingsFields()
    {
        return [];
    }

    public function modelMetaTags()
    {
        return '';
    }
}
