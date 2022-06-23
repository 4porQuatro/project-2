<?php


namespace Packages\shipping_methods\App\Models;

use App\Classes\Mutators\Price;
use App\Models\Article;
use App\Models\ModelSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\database\factories\ShippingMethodFactory;
use Packages\Store\app\Classes\Front\Shoppingcart\Cart;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ShippingMethod extends Model implements Sortable {

    use HasFactory;
    use SortableTrait;

    protected $guarded = [];

    protected $casts = ['default_price' => 'float', 'default_free_order_price' => 'float', 'active' => 'boolean'];

    /**
     * The sortable library data for this model
     *
     * @var array
     */
    public $sortable = ['order_column_name' => 'priority', 'sort_when_creating' => true,];

    protected $with = ['article'];

    protected static function newFactory()
    {
        return ShippingMethodFactory::new();
    }

    public function article()
    {
        return $this->morphOne(Article::class, 'articlable');
    }

    /**
     * Used to automatic model setting
     */
    public function getDefaultModelSetting()
    {
        return ModelSetting::where('name', 'Metódos de envio')->first()->id;
    }

    public function shippingPrices()
    {
        return $this->hasMany(ShippingPrice::class);
    }

    public function zones()
    {
        return $this->morphedByMany(Zone::class, 'shipping_methodable');
    }

    //TODO::A Eliminar no futuro
    public function setEmailsAttribute($value)
    {
        $this->attributes['emails'] = json_encode($value);
    }
    //TODO::A Eliminar no futuro
    public function getEmailsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function avaliableCountries()
    {
        $zones = $this->zones()->with(['countries', 'regions'])->get();
        $countries = collect();
        $zones->each(function ($item) use (&$countries) {
            $countries = $countries->merge($item->countries);
            $item->regions->each(function($region) use (&$countries){
               $countries = $countries->push($region->country);
            });
        });
        return  $countries->unique('id');
    }

    public static function getPricedForZonesAndCart(array $zones, Cart $cart)
    {
        $shipping_methods = self::whereHas('zones', function ($q) use ($zones) {
            $q->whereIn('zones.id', $zones);
        })->get();

        return  $shipping_methods->map(function ($item) use ($cart, $zones) {
            $item->setShippingPriceByAttributesAndCountry($zones, $cart->getShippmentWeight(), $cart->getShippmentVolume());
            if ($item->default_free_order_price > 0 && $cart->total() >= $item->default_free_order_price)
            {
                $item->price = 0;
            }

            return $item;
        });
    }

    public function setShippingPriceByAttributesAndCountry(array $zones, float $weight, float $volume)
    {
        $shipping_prices = $this->getShippingPrices($zones, $weight, $volume);
        if(!empty($shipping_prices) && $shipping_prices->price > $this->default_price)
        {
           $this->price = $this->convertPrice($shipping_prices->price);
           $this->default_free_order_price = $this->convertPrice($shipping_prices->free_order_price);
        } else {
            $this->price = $this->convertPrice($this->default_price ?? 0);
            $this->default_free_order_price = $this->convertPrice($this->default_free_order_price ?? 0);
        }
    }

    private function convertPrice($price): float
    {
        $price = (new Price($price, 0));
        $price->setToRate($this->sessionRate());
        return round($price->get(), 2);
    }

    public function sessionRate()
    {
        return SessionVariable::getPriceRate();
    }


    /**
     * @param array $zones
     * @param float $weight
     * @param float $volume
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    private function getShippingPrices(array $zones, float $weight, float $volume)
    {
        $shipping_prices = $this->shippingPrices()
            ->where(fn ($q) => $q->where('shipping_method_id', $this->id)->whereIn('priceable_id', $zones)->where('priceable_type', Zone::class)->where('min_weight', '<=', $weight)->where('max_weight', '>=', $weight))
            ->orWhere(fn ($q) => $q->where('shipping_method_id', $this->id)->whereIn('priceable_id', $zones)->where('priceable_type', Zone::class)->where('min_volume', '<=', $volume)->where('max_volume', '>=', $volume))
            ->orderBy('price', 'desc')->first();
        return $shipping_prices;
    }


}
