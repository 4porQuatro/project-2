<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use Illuminate\Support\Str;
use Packages\Country\App\Models\Country;

class MoloniCustomer {
    public $client;

    public function __construct()
    {
        $this->client = new MoloniClient();
    }

    public function getByVat($vat)
    {
        $data = ['vat'=>$vat];

        return $this->client->postApi('customers', 'getByVat', $data)->json();
    }

    public function create($data)
    {
        $customer_data = [];
        $customer_data['company_id'] = $this->client->company_id;
        $customer_data['vat'] = $data['billing_nif'];
        $customer_data['number'] = Str::orderedUuid()->toString();
        $customer_data['name'] = $data['billing_name'];
        $customer_data['language_id'] = 1;
        $customer_data['address'] = $data['billing_address'];
        $customer_data['zip_code'] = $data['billing_post_code'];

        $country_data = $this->client->postApi('countries', 'getAll')->json();
        $country = Country::where('id', $data['billing_country'])->first();

        foreach ($country_data as $ct)
        {
            strtolower($ct['iso_3166_1']) === strtolower($country->code) ? $customer_data['country_id'] = $ct['country_id'] : '';
        }
        $maturity_data = $this->client->postApi('maturityDates', 'getAll')->json();
        $days = 100000;
        foreach ($maturity_data as $item)
        {
            if ($item['days'] < $days)
            {
                $days = $item['days'];
                $customer_data['maturity_date_id'] = $item['maturity_date_id'];
            }
        }
        $payment_methods = $this->client->postApi('paymentMethods', 'getAll')->json();
        $customer_data['payment_method_id'] = $payment_methods[0]['payment_method_id'];
        $customer_data['salesman_id'] = '';
        $customer_data['payment_day'] = '';
        $customer_data['discount'] = '';
        $customer_data['credit_limit'] = '';
        $customer_data['delivery_method_id'] = '';
        return $this->client->postApi('customers', 'insert', $customer_data)->json();
    }

}
