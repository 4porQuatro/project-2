<?php

namespace Packages\Orders\App\Providers\Invoice\InvoiceExpress;

use App\Classes\Providers\ProviderInterface;
use Packages\Orders\App\Providers\Invoice\InvoiceProvider;

class InvoiceExpress extends InvoiceProvider implements ProviderInterface {


    public function authenticationData()
    {
        return [
            'ACCOUNT_NAME'=> 'Account name',
            'API_KEY'=>'API KEY',
        ];
    }

    public function pathBladeHelp()
    {
        return 'order::cms.help.invoice_express';
    }

    public function createInvoice()
    {
        return (new InvoiceExpressInvoice($this->order))->create();
    }

    public function getInvoiceDownloadLink()
    {
        return $this->hasInvoice() ? $this->order->invoice_data['invoice']['permalink'] : '';
    }

    public function hasInvoice()
    {
        return !empty($this->order->invoice_data) && isset($this->order->invoice_data['invoice'])  && isset($this->order->invoice_data['invoice']['permalink']);
    }
}
