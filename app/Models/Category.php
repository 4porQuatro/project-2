<?php

namespace App\Models;

use App\Classes\Front\Url\UrlGenerator;
use App\Interfaces\Pathable;
use App\Interfaces\Seoable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Category extends Model implements Sortable, Pathable, Seoable
{
    use Translatable;
    use SortableTrait;
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are translated.
     *
     * @var array
     */
    public $translatedAttributes = [
        'name',
        'slug'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categorable',
        'parent_id',
        'level',
        'priority',
        'fields',
        'deletable'
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

    public $casts = [
        'deletable'=>'boolean',
    ];

    public $appends = [
        'path',
    ];

    /**
     * Change value of fields attribute before save
     */
    public function setFieldsAttribute($value)
    {
        $this->attributes['fields']=json_encode($value);
    }

    /**
     * Decodes the fields attribute before returning
     */
    public function getFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     *  The parent category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function path()
    {
        $base_url = UrlGenerator::get();

        return !empty($this->article->slug) ? $base_url.'category/'.$this->article->slug : null;
    }

    public function getPathAttribute()
    {
        return $this->path();
    }

    public function categorables()
    {
        $categorable = $this->categorable ?? Article::class;
        return $this->morphedByMany($categorable, 'categorable');
    }

    /**
     *  The childrens categories
     */
    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id')->ordered();
    }

    public function getAllChildrens()
    {
        $childrens = new Collection();

        foreach ($this->childrens()->ordered()->get() as $children) {
            $childrens->push($children);
            $childrens = $childrens->merge($children->getAllChildrens());
        }

        return $childrens;
    }

    public function getAllAscendents()
    {
        $ascendents = new Collection();

        $parent = $this->parent;
        while(!empty($parent))
        {
            $ascendents->push($parent);
            $parent = $parent->parent;
        }

        return $ascendents;
    }
    /**
     * Used for descriptions
     */
    public function article()
    {
        return $this->morphOne(Article::class, 'articlable');
    }

    /**
     * Used to automatic model setting
     */
    public function getDefaultModelSetting()
    {
        if(self::where('parent_id', $this->parent_id)->whereHas('article', function ($q){
            $q->whereNotNull('model_setting_id');
        })->exists())
        {
            return self::where('parent_id', $this->parent_id)->whereHas('article', function ($q){
                $q->whereNotNull('model_setting_id');
            })->first()->article->model_setting_id;
        } elseif(self::where('id', $this->parent_id)->whereHas('article', function ($q){
            $q->whereNotNull('model_setting_id');
        })->exists()){
            return self::where('id', $this->parent_id)->whereHas('article', function ($q){
                $q->whereNotNull('model_setting_id');
            })->first()->article->model_setting_id;
        }

        return null;
    }


    /**
     * Get the seo of this category
     */
    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    /**
     * Scope the categories that don´t have a parent
     */
    public function scopeWithoutParent($query)
    {
        return $query->where('parent_id', 0)->orWhereNull('parent_id');
    }

    /**
     * Get all the articles that are assigned to this category
     */
    public function articles()
    {
        return $this->morphedByMany(Article::class, 'categorable')->ordered();
    }

    /**
     * Get all of the tags for the post.
     */
    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->using(SectionPivot::class)->withPivot([
            'priority',
            'active'
        ]);

    }

    public function externalReference()
    {
        return $this->morphOne(ExternalReference::class, 'external_referenceable');
    }

    public function getPathables()
    {
        return self::whereHas('article')->get()->pluck('name', 'id')->toArray();
    }

    public function previewPath()
    {
        return $this->path();
    }

    public function modelMetaTags()
    {
        return '';
    }
}
