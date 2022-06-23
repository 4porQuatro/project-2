<?php


namespace Packages\Country\App\Http\Controllers;


use App\Http\Controllers\Controller;
use Packages\Country\App\Models\Country;

class RegionsController extends Controller {

    public function getByCountry(Country $country)
    {
        return $country->regions()->where('active', 1)->orderBy('name', 'asc')->get();
    }


}
