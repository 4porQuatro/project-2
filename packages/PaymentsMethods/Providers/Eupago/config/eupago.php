<?php
$end_point = 'https://sandbox.eupago.pt/replica.eupagov14.wsdl';
if(env('APP_ENV') === 'production')
{
    $end_point = 'https://clientes.eupago.pt/eupagov20.wsdl';
}

return [
    'end_point'=>$end_point,
    'api_key'=>'demo-c791-5733-7c32-19b'
];


//PRODUCTION

/**
 return [
'end_point'=>'https://clientes.eupago.pt/eupagov20.wsdl',
'api_key'=>'d917-bb0b-6800-0ecb-ec9e'
];
 * **/

