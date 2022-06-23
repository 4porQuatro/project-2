<?php

namespace Packages\Country\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Country;


class UserCountryController extends Controller {

    public function update(Request $request)
    {
        $this->validate($request, ['country_id'=>'required']);
        $country = Country::where('active', 1)->where('id', $request->country_id)->first();
        SessionVariable::setUserShippingCountry($country);
        if($request->has('set_rate') && $request->get('set_rate') == 1)
        {
            SessionVariable::setPriceRate($country->currency);
        }
        if($request->has('set_tax'))
        {
            SessionVariable::setUserTaxes($country->defaultTax());
        }

        return response('', 200);
    }
}
