<?php

namespace Packages\Store\app\Models;

use App\Classes\Mutators\Price;
use App\Interfaces\Categorable;
use App\Interfaces\ModelSettignable;
use App\Interfaces\Pathable;
use App\Interfaces\Seoable;
use App\Models\Category;
use App\Models\ExternalReference;
use App\Models\Layout;
use App\Models\Section;
use App\Models\Sectionable;
use App\Models\Seo;
use App\Models\Setting;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\Cache;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Currency;
use Packages\Country\App\Models\Tax;
use Packages\Store\app\Classes\Repositories\ProductRepository;
use Packages\Store\app\Interfaces\Buyable;
use Packages\Store\database\factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Product extends Model implements Sortable, Pathable, Buyable, ModelSettignable, Seoable, Categorable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    public $fillable = [
        'attribute_family_id',
        'parent_id',
        'images',
        'images_detail',
        'videos',
        'docs',
        'default_layout',
        'priority',
        'layout_id',
        'price',
        'promoted_price',
        'stock',
        'has_variants',
        'sku',
        'ref',
        'model_setting_id',
        'shippment_length',
        'shippment_weight',
        'shippment_width',
        'shippment_height'
    ];

    public $translatedAttributes = [
        'title',
        'slug',
        'small_body',
        'body',
        'active',
        'promoted',
        'highlighted'
    ];

    protected $casts = [
        'default_layout'=>'boolean',
        'priority'=>'integer',
        'price'=>'float',
        'promoted_price'=>'float',
        'stock'=>'int',
        'has_variants'=>'boolean',
        'shippment_length'=>'integer',
        'shippment_weight'=>'integer',
        'shippment_width'=>'integer',
        'shippment_height'=>'integer'
    ];

    protected $appends = [
        'final_price',
        'currency_price',
        'title_translated',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Produtos' : 'Produto';
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

    public function getCurrencyPriceAttribute()
    {
        return (new Currency)->getActiveCurrency();
    }

    public function getImagesAttribute($value)
    {
        $images_array = json_decode($value, true);
        if(empty($images_array) && ! $this->has_variants && !empty($this->parent_id))
        {
            $images_array = $this->parent->images;
        }
        return $images_array ?? [];
    }

    public function getImagesDetailAttribute($value)
    {
        $images_array = json_decode($value, true);
        if(empty($images_array) && ! $this->has_variants && !empty($this->parent_id))
        {
            $images_array = $this->parent->images_detail;
        }
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

    public function getPathAttribute()
    {
        return $this->path();
    }

    public function getAttributesAttribute()
    {
        return $this->family->attributes()->with('translations')->get()->keyBy('admin_title');
    }

    public function getAttributesOptionsAttribute()
    {
        return $this->attributeOptions()->with(['translations', 'attribute.translations'])->get()->groupBy('attribute.admin_title');
    }

    public function getTitleTranslatedAttribute()
    {
        return !empty($this->parent_id) ? $this->parent->title : $this->title;
    }

    public function getDefaultVariationAttribute()
    {
        $variation = $this->variations()->with(['translations'])->first() ?? new Product();

        return $variation->append('attributesOptions');
    }

    public function scopeActive($q)
    {
        return $q->whereTranslation('active', true, app()->getLocale());
    }

    public function scopePromoted($q)
    {
        return $q->whereTranslation('promoted', true, app()->getLocale());
    }

    public function scopeHighlighted($q)
    {
        return $q->whereTranslation('highlighted', true, app()->getLocale());
    }

    public function scopePrimary($q)
    {
        return $q->whereNull('parent_id');
    }

    public function scopeFilter($q, array $attributes)
    {
        return (new ProductRepository($q, $attributes))->filter();
    }

    public function scopeWithStock($q)
    {
        return $q->where('stock', '>', 0);
    }

    public function variations()
    {
        return $this->hasMany(Product::class, 'parent_id')->ordered();
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    public function family()
    {
        return $this->belongsTo(AttributeFamily::class, 'attribute_family_id');
    }

    public function attributeOptions()
    {
        return $this->belongsToMany(AttributeOption::class);
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

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public function optionals()
    {
        return $this->belongsToMany(Product::class, 'optional_product', 'product_id', 'product_optional_id');
    }

    public function externalReference()
    {
        return $this->morphOne(ExternalReference::class, 'external_referenceable');
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

    public function path()
    {
        return env('APP_URL').'/product/'.$this->slug;
    }

    public function getPathables()
    {
        // TODO: Implement getPathables() method.
    }

    public function previewPath()
    {
       return $this->path();
    }

    public function detailView()
    {
        return 'front.product.show';
    }

    public function totalStock()
    {
        return $this->has_variants ? $this->variations->sum('stock') : $this->stock;
    }

    public function canBeBought(): bool
    {
        return $this->has_variants == false && $this->stock > 0 && $this->active == true;
    }

    public function getBuyablePrice()
    {
        $product_price = !empty($this->promoted_price) && $this->promoted_price > 0 && $this->promoted_price < $this->price ? $this->promoted_price : $this->price;
        $product_price = !empty($product_price) ? $product_price : 0;

        return $product_price;
    }


    public function getPromotedPriceAttribute($value)
    {
        if(auth()->check() && auth()->user()->cmsAllowed())
            return $value;
        return $this->convertPrice($value ?? 0);
    }

    public function getPriceAttribute($value)
    {
        if(auth()->check() &&  auth()->user()->cmsAllowed())
            return $value;

        return $this->convertPrice($value);
    }

    public function getTaxIncluded()
    {
        return $this->priceHasTaxesIncluded() ? (float) Tax::getDefault() : 0;
    }

    public function getPriceWithoutTax()
    {
        return $this->price/(1+$this->getTaxIncluded());
    }

    public function sessionTax()
    {
        return SessionVariable::getUserTaxes();
    }

    public function sessionRate()
    {
        return SessionVariable::getPriceRate();
    }

    public static function getModelSettingsFields()
    {
        return [];
    }

    public function getFinalPriceAttribute()
    {
        return $this->getBuyablePrice();
    }

    public function priceHasTaxesIncluded()
    {
        $product_settings = Cache::rememberForever('product_settings', function (){
            return Setting::getByName('product_settings')->data;
        });

        return (bool) $product_settings['taxes_included'];
    }

    public function getShippmentVolume()
    {
        return $this->shippment_width*$this->shippment_length*$this->shippment_height;
    }

    public function getShippmentWeight()
    {
        return $this->shippment_weight;
    }

    /**
     * @param $product_price
     * @return float
     */
    private function convertPrice($product_price): float
    {
        $price = (new Price($product_price, $this->getTaxIncluded()));
        $price->setTaxes($this->sessionTax());
        $price->setToRate($this->sessionRate());
        return round($price->get(), 2);
    }

    public function modelMetaTags()
    {
        $title = $this->seo->title;
        $description = $this->seo->description;
        $price = $this->final_price;
        $availability = $this->stock > 0 ? 'in stock' : 'out of stock';

        return '<meta property="product:retailer_item_id" content="' . $this->id . '">' . PHP_EOL .
            '<meta property="og:title" content="' . $title . '">' . PHP_EOL .
            '<meta property="og:description" content="' . $description . '"/>' . PHP_EOL .
            '<meta property="og:url" content="' . $this->path() . '"/>' . PHP_EOL .
            '<meta property="product:price:amount" content="' . $price . '">' . PHP_EOL .
            '<meta property="product:availability" content="' . $availability . '"/>' . PHP_EOL .
            '<meta property="product:brand" content="' . config('app.name') . '"/>' . PHP_EOL .
            '<meta property="product:price:currency" content="EUR"/>' . PHP_EOL .
            '<meta property="product:condition" content="new"/>';
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
