<?php

namespace Packages\Country\database\seeders;

use Illuminate\Database\Seeder;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;
use Packages\shipping_methods\App\Models\ShippingMethod;

class ZoneSeeder extends Seeder {

    public function run()
    {
        $zone = Zone::create(['name'=>'Global zone']);
        $zone->undeletable = true;
        $zone->save();

        $zone->countries()->attach(Country::where('active', 1)->get());
        ShippingMethod::all()->each(function($method) use ($zone){
           $method->zones()->attach([$zone->id]);
           $method->shippingPrices()->get()->each(function($price) use ($zone){
               $price->update(['priceable_id'=>$zone->id, 'priceable_type'=>Zone::class]);
           });
        });
    }

}
