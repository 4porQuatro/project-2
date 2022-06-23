<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use Carbon\Carbon;
use Packages\Country\App\Models\Currency;
use Packages\Orders\App\Models\Order;

class MoloniInvoice {

    public $invoice_data;
    public $client;
    public $order;
    public $exchange_rate = 1;

    public function __construct(Order $order)
    {
        $this->client = new MoloniClient();
        $this->order = $order;
    }

    public function create()
    {
        $this->setCompanyId();
        $this->setCurrency();
        $this->serDate();
        $this->setExpirationDate();
        $this->setDocumentId();
        $this->setCustomerId();
        $this->setAlternateAddressId();
        $this->setOurReference();
        $this->setYourReference();
        $this->setFinancialDiscount();
        $this->setEacId();
        $this->setSalesmanId();
        $this->setProducts();
        $this->setShippingService();
        $this->setStatus();

        $response = $this->client->postApi('invoices', 'insert', $this->invoice_data)->json();
        return $response;
    }
    public function setCompanyId()
    {
        $this->invoice_data['company_id'] = $this->client->company_id;
    }

    private function serDate()
    {
        $this->invoice_data['date'] = Carbon::now()->toDateString();
    }

    private function setExpirationDate()
    {
        $this->invoice_data['expiration_date'] = Carbon::now()->toDateString();
    }

    private function setDocumentId()
    {
        foreach($this->client->postApi('documentSets', 'getAll')->json() as $item)
            $item['active_by_default'] ? $this->invoice_data['document_set_id'] = $item['document_set_id'] :'';
    }

    private function setCustomerId()
    {
        $this->invoice_data['customer_id'] = '';
        $moloni_customer = (new MoloniCustomer());
        $billing_data = $this->order->billing_address_data;
        $data = $moloni_customer->getByVat($billing_data['billing_nif']);
        if (empty($data))
        {
            $data = $moloni_customer->create($billing_data);
            $this->invoice_data['customer_id'] = $data['customer_id'];
        } else
        {
            $this->invoice_data['customer_id'] = $data[0]['customer_id'];
        }
    }

    private function setAlternateAddressId()
    {
        $this->invoice_data['alternate_address_id'] = '';
    }

    private function setOurReference()
    {
        $this->invoice_data['our_reference'] = '';
    }

    private function setYourReference()
    {
        $this->invoice_data['your_reference'] = $this->order->uuid;
    }

    private function setFinancialDiscount()
    {
        $this->invoice_data['special_discount'] = $this->order->total_discount/$this->exchange_rate;
        $this->invoice_data['financial_discount']  = '';
    }

    private function setEacId()
    {
        $this->invoice_data['eac_id'] = '';
    }

    private function setSalesmanId()
    {
        $this->invoice_data['salesman_id'] = '';
    }

    private function setSalesmanCommision()
    {
        $this->invoice_data['salesman_commission'] = '';
    }

    private function setSpecialDiscount()
    {
        $this->invoice_data['special_discount'] = '';
    }

    private function setProducts()
    {
        $products = [];
        $moloni_product = new MoloniProduct($this->invoice_data['company_id']);
        foreach($this->order->items as $item)
        {
            $products[] = $moloni_product->getWithQty($item->itemable, $item->quantity);
        }
        $this->invoice_data['products'] = $products;
    }

    private function setShippingService()
    {
        if($this->order->total_shipping > 0)
        {
            $moloni_transportation = new MoloniShipping($this->order, $this->invoice_data['company_id']);
            $this->invoice_data['products'][] = $moloni_transportation->getLineDetail();
        }
    }

    private function setCurrency()
    {
        $data = $this->client->postApi('currencies', 'getAll')->json();
        $order_currency = Currency::find($this->order->currency_id);
        foreach($data as $currency)
        {
            if($currency['iso4217'] === $order_currency->code && $this->order->currency_rate != 1)
            {
                $this->invoice_data['exchange_currency_id'] = $currency['currency_id'];
                $this->invoice_data['exchange_rate'] = $this->order->currency_rate;
                $this->exchange_rate = $this->order->currency_rate;
            }
        }


    }

    private function setStatus()
    {
        $this->invoice_data['status'] = 1;
    }


}
