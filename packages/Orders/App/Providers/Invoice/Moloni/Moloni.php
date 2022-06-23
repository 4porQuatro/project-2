<?php

namespace Packages\Orders\App\Providers\Invoice\Moloni;

use App\Classes\Providers\ProviderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Packages\Country\App\Models\Currency;
use Packages\Orders\App\Models\Order;
use Packages\Orders\App\Providers\Invoice\InvoiceProvider;

class Moloni extends InvoiceProvider implements ProviderInterface {


    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function createInvoice()
    {
        return (new MoloniInvoice($this->order))->create();
    }

    public function getInvoice()
    {
        $client = new MoloniClient();
        return $client->postApi('documents', 'getPDFLink', ['document_id' => $this->order->invoice_data['document_id']])->json();
    }


    public function authenticationData()
    {
        return ['client_id' => 'Client ID', 'client_secret' => 'Client secret', 'username' => 'Username', 'password' => 'Password', 'nif' => 'Número de contribuinte da loja'];
    }

    public function pathBladeHelp()
    {
        return 'order::cms.help.moloni';
    }


    public function getInvoiceDownloadLink()
    {
        return $this->hasInvoice() ? $this->getInvoice()['url'] : '';
    }

    public function hasInvoice()
    {
        return !empty($this->order->invoice_data) && $this->order->invoice_data['valid'] === 1;
    }
}
