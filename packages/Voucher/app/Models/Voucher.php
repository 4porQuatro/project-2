<?php

namespace Packages\Voucher\app\Models;

use App\Classes\Mutators\Price;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Store\app\Models\Product;
use Packages\Voucher\database\factories\VoucherFactory;

class Voucher extends Model {

    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['active'=>'boolean', 'percentage_discout'=>'float', 'discount_value'=>'float'];
    protected $dates = [
        'created_at',
        'updated_at',
        'expires_at'
    ];


    public static function newFactory()
    {
        return VoucherFactory::new();
    }

    /**
     * Set the code.
     *
     * @param  string  $value
     * @return void
     */
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = !empty($value) ? $value : Str::random(3).'-'.Str::random(5);
    }

    public function setDiscountValueAttribute($value)
    {
        $this->attributes['discount_value'] = $value ?? 0;
    }

    public function setPercentageDiscountAttribute($value)
    {
        $this->attributes['percentage_discount'] = $value ?? 0;
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'voucherable');
    }

    public function voucherables($model)
    {
        return $this->morphedByMany($model, 'voucherable');
    }

    public function getDiscountValueAttribute($value)
    {
        if(auth()->check() && auth()->user()->cmsAllowed())
            return $value;

        $price = (new Price($value, 0));
        $price->setToRate($this->sessionRate());
        return round($price->get(), 2);
    }

    public function sessionRate()
    {
        return SessionVariable::getPriceRate();
    }

    public function getOrderDiscount($items)
    {
        $total_dicount = 0;
        if($this->percentage_discount > 0)
        {
            foreach($items as $item)
            {
                if($this->products->contains($item))
                {
                    $total_dicount += $item->getBuyablePrice()*$item->qty*$this->percentage_discount/100;
                }
                if($this->products->where('id', $item->parent_id)->count())
                {
                    $total_dicount += $item->getBuyablePrice()*$item->qty*$this->percentage_discount/100;
                }
            }
        }
        if($this->discount_value < $total_dicount && $this->discount_value >0 || $this->percentage_discount == 0.0)
        {
            $total_dicount = $this->discount_value;
        }
        return $total_dicount;
    }


}
