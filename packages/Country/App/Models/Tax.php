<?php


namespace Packages\Country\App\Models;


use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Packages\Country\database\factories\CountryFactory;
use Packages\Country\database\factories\TaxFactory;

class Tax extends Model {

    use HasFactory;

    protected $fillable = ['percentage'];

    protected static function newFactory()
    {
        return TaxFactory::new();
    }

    public function taxable()
    {
        return $this->morphTo();
    }

    public static function getDefault()
    {
        $product_settings = Cache::remember('default_tax',3600, function (){
            return Setting::getByName('default_tax')->data;
        }, );

        return (float) $product_settings['default_value']/100;
    }

}
