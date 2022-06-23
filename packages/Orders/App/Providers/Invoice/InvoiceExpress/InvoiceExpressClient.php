<?php

namespace Packages\Orders\App\Providers\Invoice\InvoiceExpress;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Packages\Orders\App\Models\InvoiceProvider;
use GuzzleHttp\Client;


class InvoiceExpressClient {

    public function getAccountName()
    {
        return Cache::remember('account_name_invoice_express', 3600, function (){
            $credentials = collect(InvoiceProvider::get()->data)->first();
            return $credentials['ACCOUNT_NAME'];
        });
    }

    public function getApiKey()
    {
        return Cache::remember('api_key_invoice_express', 3600, function (){
            $credentials = collect(InvoiceProvider::get()->data)->first();
            return $credentials['API_KEY'];
        });
    }

    public function post($method, $data)
    {
        //dd('https://'.$this->getAccountName().'.app.invoicexpress.com/'.$method.'?api_key='.$this->getApiKey().' '. 'https://a4por4-2.app.invoicexpress.com/invoices.json?api_key=c4eadccd4afd6c6e8c40716181650f4fd4a2e6ae');
        return Http::post('https://'.$this->getAccountName().'.app.invoicexpress.com/'.$method.'?api_key='.$this->getApiKey(),
            $data)->json();
    }


    public function test()
    {}

    /**
     * @return array
     */
    private function getHeaders(): array
    {
        return ['Content-Type' => 'application/xml; charset=utf-8'];
    }
}
