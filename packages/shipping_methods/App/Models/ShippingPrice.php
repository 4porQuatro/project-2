<?php


namespace Packages\shipping_methods\App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\shipping_methods\database\factories\ShippingPriceFactory;

class ShippingPrice extends Model {

    use HasFactory;

    protected $fillable = [
        'min_weight',
        'max_weight',
        'min_volume',
        'max_volume',
        'price',
        'free_order_price',
        'priceable_type',
        'priceable_id'
    ];

    protected $casts = [
        'min_volume'=>'integer',
        'max_volume'=>'integer',
        'min_weight'=>'integer',
        'max_weight'=>'integer',
        'price'=>'float',
        'free_order_price'=>'float'
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function priceable()
    {
        return $this->morphTo();
    }

    protected static function newFactory()
    {
        return ShippingPriceFactory::new();
    }
}
