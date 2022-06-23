<?php

namespace Packages\Country\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;

class ZonesController extends Controller {

    public function get()
    {
        $zones = Category::where('categorable', Country::class)->get();
        $zones = $zones->map(function($zone) {
            $zone->countries = $zone->categorables;
            return $zone;
        });
        return $zones;
    }
}
