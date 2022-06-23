<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Packages\Orders\App\Models\InvoiceProvider;

class MoloniClient {

    public $token;
    public $company_id;

    public function __construct()
    {
        $this->setToken();
        $this->setCompanyId();
    }

    public function getCredencials()
    {
        return collect(InvoiceProvider::get()->data)->first();
    }

    public function setToken()
    {
        $credentials = $this->getCredencials();
        $this->token = Cache::remember('token_moloni', 3600, function () use ($credentials) {
            $response = Http::get(config('moloni.end_point') . 'grant/?grant_type=password&client_id=' . $credentials['client_id'] . '&client_secret=' . $credentials['client_secret'] . '&username=' . $credentials['username'] . '&password=' . $credentials['password']);
            $login = json_decode($response->body());

            return $login->access_token;
        });
    }

    public function setCompanyId()
    {
        $credentials = $this->getCredencials();
        $this->company_id = Cache::remember('moloni_company_id', 3600, function () use ($credentials) {
            $response = Http::get($this->endPoint() . '/companies/getAll/?access_token=' . $this->token);
            $data = json_decode($response->body());
            foreach ($data as $value)
            {
                if ($value->vat === $credentials['nif'])
                {
                    return $value->company_id;
                }
            }
        });
    }


    public function endPoint()
    {
        return config('moloni.end_point');
    }

    public function postApi($key, $method, array $data = [])
    {
        $data['company_id'] = $this->company_id;
        return  Http::asForm()->post($this->endPoint() . '/'.$key.'/'.$method.'/?access_token=' . $this->token, $data);
    }


}
