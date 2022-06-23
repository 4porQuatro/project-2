<?php
$end_point = 'https://api.test.easypay.pt/2.0/';
if(env('APP_ENV') === 'production')
{
    $end_point = 'https://api.prod.easypay.pt/2.0/';
}

return [
    'end_point'=>$end_point,
    'account_id'=>'4b675448-fd4d-4c97-bd6f-7817663a0cf9',
    'api_key'=>'93e83fd2-9093-447d-b964-56ae653c625a'
];
