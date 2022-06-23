<?php

namespace Packages\PaymentsMethods\Providers\Eupago;

use Packages\Orders\App\Models\Order;
use Packages\PaymentsMethods\App\Models\PaymentProviders;

class EuPagoPayload {

    public function check()
    {
        $this->credencials = (new PaymentProviders())->getDataProvider(EuPago::class);
        if(! request()->has('chave_api') && $this->credencials['api_key'] === request()->get('chave_api'))
        {
            abort(404, 'Dados inválidos');
        }

        $order = Order::findOrFail(request()->get('identificador'));
        if($order->grand_total === floatval(request()->get('valor')))
        {
            return ['success'=>true, 'field'=>'id', 'condition'=>'=', 'data'=>request()->get('identificador')];
        }

        abort(404, 'Aconteceu um erro inesperado');
    }



}
