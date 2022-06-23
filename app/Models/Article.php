<?php

namespace App\Models;

use App\Classes\Front\Url\UrlGenerator;
use App\Classes\Repositories\Article\ArticleRepository;
use App\Interfaces\Categorable;
use App\Interfaces\Pathable;
use App\Interfaces\Seoable;
use App\Interfaces\ModelSettignable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
class Article extends Model implements Sortable, Pathable, ModelSettignable, Seoable, Categorable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    public $fillable = [
        'start_date',
        'end_date',
        'published_date',
        'images',
        'images_detail',
        'videos',
        'docs',
        'default_layout',
        'priority',
        'model_setting_id',
        'layout_id',
    ];

    public $translatedAttributes = [
        'title',
        'slug',
        'subtitle',
        'small_body',
        'body',
        'link',
        'link_text',
        'active',
        'promoted'
    ];

    protected $casts = [
        'default_layout'=>'boolean',
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

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Artigos' : 'Artigo';
    }


    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function setImagesDetailAttribute($value)
    {
        $this->attributes['images_detail'] = json_encode($value);
    }
    public function setVideosAttribute($value)
    {
        $this->attributes['videos'] = json_encode($value);
    }
    public function setDocsAttribute($value)
    {
        $this->attributes['docs'] = json_encode($value);
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
    public function getVideosAttribute($value)
    {
        $videos_array = json_decode($value, true);
        return $videos_array ?? [];
    }
    public function getDocsAttribute($value)
    {
        $docs_array = json_decode($value, true);
        return $docs_array ?? [];
    }

    public function scopeActive($q)
    {
        return $q->whereTranslation('active', true, app()->getLocale());
    }

    public function scopeFilter($q, array $attributes = [])
    {
        return (new ArticleRepository($q, $attributes))->filter();
    }

    public function scopePromoted($q)
    {
        return $q->whereTranslation('promoted', true, app()->getLocale());
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

    public function getLayout()
    {
        return !empty($this->layout_id) ? $this->layout : Layout::default()->first();
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorable');
    }

    public function articlable()
    {
        return $this->morphTo();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public function related()
    {
        return $this->belongsToMany(Article::class, 'article_article', 'article_id', 'related_article_id');
    }

    public function activeRelated()
    {
        return $this->related()->active();
    }

    public function path()
    {
        $base_url = UrlGenerator::get();

        return $base_url.'article/'.$this->slug;
    }

    public function getPathables()
    {
        return self::where(function ($q){
            $q->where('default_layout', 0)->orWhereHas('sections');
        })->get()->pluck('title', 'id')->toArray();
    }

    public function previewPath()
    {
        return $this->path();
    }

    public function facebookShareLink()
    {
        return 'https://www.facebook.com/sharer/sharer.php?u=' . $this->path();
    }

    public function linkedinShareLink()
    {
        return 'https://www.linkedin.com/shareArticle?mini=true&summary='.$this->subtitle.'&title='.$this->title.'&url='.$this->path();
    }

    public function twitterShareLink()
    {
        return 'https://twitter.com/intent/tweet?url=' . $this->path();
    }

    public function emailShareLink()
    {
        return 'mailto:?subject='.$this->title.'&amp;body='.$this->path().'%0A';
    }

    public function modelSetting()
    {
        return $this->belongsTo(ModelSetting::class);
    }

    public static function getModelSettingsFields()
    {
        return [
            'categories'=>'Categorias',
            'title'=>'Titulo',
            'subtitle'=>'Subtitulo',
            'slug'=>'Slug',
            'published_date'=>'Data de Publicação',
            'start_date'=>'Data de Inicio',
            'end_date'=>'Data de Fim',
            'link'=>'Link',
            'link_text'=>'Texto link',
            'small_body'=>'Pequena descrição',
            'body'=>'Descrição',
            'images'=>'Imagens',
            'images_detail'=>'Imagens detalhe',
            'videos'=>'Videos',
            'docs'=>'Documentos',
            'related_articles'=>'Artigos relacionados',
            'tags'=>'Tags'
        ];
    }

    public function detailView()
    {
        return $this->modelSetting->component_path ?? 'front.core.layout_detail';
    }

    public function nextLink()
    {
        $next = $this->next();

        return $next ? $next->path() : null;
    }

    public function next()
    {
        $main_category = $this->categories->where('level', 0)->first()->id;

        $next = $this->whereHas('categories', function($q) use ($main_category){
            $q->where('categories.id', $main_category);
        })
            ->whereTranslation('locale', app()->getLocale())
            ->where('priority', '>', $this->priority)
            ->whereTranslation('active', true)
            ->orderBy('priority', 'ASC')->first();

        return $next ? $next : null;
    }

    public function previousLink()
    {
        $previous = $this->previous();

        return $previous ? $previous->path() : null;
    }

    public function previous()
    {
        $main_category = $this->categories->where('level', 0)->first()->id;

        $previous = $this->whereHas('categories', function($q) use ($main_category){
            $q->where('categories.id', $main_category);
        })
            ->whereTranslation('locale', app()->getLocale())
            ->where('priority', '<', $this->priority)
            ->whereTranslation('active', true)
            ->orderBy('priority', 'DESC')->first();

        return $previous ? $previous : null;
    }

    public function autoGenerateSections(ModelSetting $model_setting)
    {
        foreach($model_setting->sections()->orderBy('sectionables.priority', 'asc')->get() as $sec)
        {
            $clone = $sec->replicateWithTranslations();
            $clone->active = 1;
            $clone->save();
            $this->sections()->attach([$clone->id=> ['grid_id'=> $sec->sectionable->grid_id ?? 1]]);
        }
        $this->layout_id = $model_setting->layout_id;
        $this->save();
    }

    public function modelMetaTags()
    {
        return '';
    }

    public function hasLevels()
    {
        return true;
    }

    public function isArticable()
    {
        return true;
    }

    public static function getMainSearchColumn()
    {
        return 'title';
    }
}
