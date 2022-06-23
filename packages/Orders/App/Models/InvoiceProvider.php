<?php

namespace Packages\Orders\App\Models;

use App\Classes\Providers\Provider;
use App\Models\Setting;
use Packages\Orders\App\Providers\Invoice\InvoiceExpress\InvoiceExpress;
use Packages\Orders\App\Providers\Invoice\Moloni\Moloni;

class InvoiceProvider extends Provider {
    public $avaliable_providers = [
        Moloni::class => 'Moloni',
        InvoiceExpress::class =>'Invoice Express'
    ];

    static $setting_name = 'invoice_providers';


    public static function exists()
    {
        return Setting::where('name', self::$setting_name)->exists();
    }

    public static function get()
    {
        return Setting::where('name', self::$setting_name)->first();
    }

    public static function create($data)
    {
        Setting::create(['name'=>self::$setting_name, 'data'=>$data]);
    }

    public function getSettingName()
    {
        return self::$setting_name;
    }

    public function getAvaliableProviders()
    {
        return $this->avaliable_providers;
    }
}
