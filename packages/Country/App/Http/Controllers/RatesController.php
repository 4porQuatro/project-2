<?php

namespace Packages\Country\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Country\App\Classes\Front\SessionVariable;
use Packages\Country\App\Models\Currency;

class RatesController extends Controller {

    public function update(Request $request)
    {
        $this->validate($request, ['currency_id'=>'required']);

        $currency = Currency::active()->where('id', $request->get('currency_id'))->first();
        if(!empty($currency))
        {
            SessionVariable::setPriceRate($currency);
        }
        return response('', 200);

    }

}
