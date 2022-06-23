<?php

namespace Packages\Country\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Tax;

class TaxesController extends Controller {

    public function update(Request $request)
    {
        $this->validate($request, ['country_id'=>'required']);

        $tax = Country::findOrFail($request->get('country_id'))->defaultTax();

        if(!empty($tax))
        {
            SessionVariable::setUserTaxes($tax);
        }

        return response('', 200);

    }

}
