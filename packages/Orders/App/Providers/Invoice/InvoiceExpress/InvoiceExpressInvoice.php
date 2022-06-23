<?php

namespace Packages\Orders\App\Providers\Invoice\InvoiceExpress;

use Carbon\Carbon;
use Packages\Country\App\Models\Currency;
use Packages\Orders\App\Models\Order;

class InvoiceExpressInvoice {
    public $client;
    public $payload;
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->client = new InvoiceExpressClient();
    }

    private function setDates()
    {
        $this->payload['date'] = Carbon::now()->format('d/m/Y');
        $this->payload['due_date'] = Carbon::now()->format('d/m/Y');
    }
    private function setReference()
    {
        $this->payload['reference'] = $this->order->uuid;
    }

    private function setCustomer()
    {
        $this->payload['client'] = ( new InvoiceExpressCustomer())->create($this->order->billing_address_data);
    }

    private function setProducts()
    {
        $this->payload['items'] = (new InvoiceExpressProduct())->get($this->order->items);
    }

    private function setTaxExemptionReason()
    {
        $this->payload['tax_exemption_reason'] = "M00";
    }



    private function setMbReference()
    {
        $this->payload['mb_reference'] = 0;
    }

    private function setCurrencyCode()
    {
        $this->payload['currency_code'] = Currency::find($this->order->currency_id)->code;
        $this->payload['rate'] = number_format(Currency::find($this->order->currency_id)->rate, 5, '.', '');
    }

    public function create()
    {
        $this->payload = [];
        $this->setDates();
        $this->setReference();
        $this->setCustomer();
        $this->setProducts();
        $this->setCurrencyCode();
        $this->setMbReference();
        $this->setTaxExemptionReason();
        $response = $this->client->post( 'invoices.json', ['invoice'=>$this->payload]);
        return $response;
    }
}
