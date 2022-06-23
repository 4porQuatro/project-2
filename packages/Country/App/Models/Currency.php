<?php

namespace Packages\Country\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Currency extends Model {

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function getDefault()
    {
       return Cache::remember('default_currency', 300,function(){
            return Currency::where('code', 'EUR')->first();
        });
    }

    public function getActiveCurrency()
    {
        return session()->has('currency') ? session()->get('currency') : self::getDefault();
    }


}
