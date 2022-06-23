<?php

namespace Packages\Orders\App\Providers\Invoice\InvoiceExpress;

use Packages\Country\App\Models\Country;

class InvoiceExpressCustomer {

    /**
    "name": "Client Name",
    "code": "A1",
    "email": "foo@bar.com",
    "address": "Saldanha",
    "city": "Lisbon",
    "postal_code": "1050-555",
    "country": "Portugal",
    "fiscal_id": "508000000",
    "website": "www.website.com",
    "phone": "910000000",
    "fax": "210000000",
    "observations": "Observations"
    }
     **/
    private $customer;
    private $data;

    public function create($data)
    {
        $this->data = $data;
        $this->setName();
        $this->setEmail();
        $this->setAddress();
        $this->setCity();
        $this->setPostCode();
        $this->setCountry();
        $this->setFiscalId();
        $this->setPhone();
        $this->customer['code'] = 'nabo';
        return $this->customer;
    }

    public function setName()
    {
        $this->customer['name'] = $this->data['billing_name'];
    }

    public function setEmail()
    {
        $this->customer['email'] = $this->data['billing_email'];
    }

    public function setAddress()
    {
         $this->customer['address'] = $this->data['billing_address'];
    }

    public function setCity()
    {
        $this->customer['city'] = $this->data['billing_city'];
    }

    public function setPostCode()
    {
        $this->customer['postal_code'] = isset($this->data['billing_post_code']) ? $this->data['billing_post_code'] : '';
    }

    public function setCountry()
    {
        $this->customer['country'] = Country::find($this->data['billing_country'])->name;
    }

    public function setFiscalId()
    {
        $this->customer['fiscal_id'] = $this->data['billing_nif'];
    }

    public function setPhone()
    {
        $this->customer['phone'] = $this->data['billing_phone'];
    }

}
