<?php

namespace Packages\Orders\App\Providers\Invoice;

use Packages\Orders\App\Models\Order;

abstract class InvoiceProvider {

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function saveInvoice()
    {
        $this->order->invoice_data = $this->createInvoice();
        $this->order->save();
        return $this->order;
    }

    abstract public function createInvoice();
    abstract public function getInvoiceDownloadLink();
    abstract public function hasInvoice();
}
