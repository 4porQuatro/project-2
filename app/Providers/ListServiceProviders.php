<?php


namespace App\Providers;



use Packages\Country\CountryServiceProvider;
use Packages\ImageHotspots\ImageHotspotsServiceProvider;
use Packages\Orders\OrderServiceProvider;
use Packages\PaymentsMethods\PaymentsMethodServiceProvider;
use Packages\shipping_methods\ShippingMethodsServiceProvider;
use Packages\Documents\DocumentsServiceProvider;
use Packages\Voucher\VoucherServiceProvider;

class ListServiceProviders {

    public $packages = [
        'APP_RESERVED'=> \Packages\Reserved\ReservedServiceProvider::class,
        'APP_STORE'=> \Packages\Store\StoreServiceProvider::class,
        'APP_ORDERS'=> OrderServiceProvider::class,
        'APP_PAYMENT_METHODS'=>PaymentsMethodServiceProvider::class,
        'APP_SHIPPMENT_METHODS'=>ShippingMethodsServiceProvider::class,
        'APP_COUNTRY'=>CountryServiceProvider::class,
        'APP_DOCUMENTS'=>DocumentsServiceProvider::class,
        'APP_IMAGE_HOTSPOTS'=>ImageHotspotsServiceProvider::class,
        'APP_VOUCHER'=>VoucherServiceProvider::class,
    ];

    public function generate()
    {
        return array_merge($this->generateLaravelServiceProviders(), $this->generatePackageServiceProviders(), $this->generateApplicationServiceProviders());
    }

    public function generatePackageServiceProviders()
    {
        $providers = [];

        foreach($this->packages as $key =>$pack)
        {
            if(env($key))
            {
                $providers[] = $pack;
            }
        }

        return $providers;
    }

    public function generateLaravelServiceProviders()
    {
        return [\Illuminate\Auth\AuthServiceProvider::class,
            \Illuminate\Broadcasting\BroadcastServiceProvider::class,
            \Illuminate\Bus\BusServiceProvider::class,
            \Illuminate\Cache\CacheServiceProvider::class,
            \Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
            \Illuminate\Cookie\CookieServiceProvider::class,
            \Illuminate\Database\DatabaseServiceProvider::class,
            \Illuminate\Encryption\EncryptionServiceProvider::class,
            \Illuminate\Filesystem\FilesystemServiceProvider::class,
            \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
            \Illuminate\Hashing\HashServiceProvider::class,
            \Illuminate\Mail\MailServiceProvider::class,
            \Illuminate\Notifications\NotificationServiceProvider::class,
            \Illuminate\Pagination\PaginationServiceProvider::class,
            \Illuminate\Pipeline\PipelineServiceProvider::class,
            \Illuminate\Queue\QueueServiceProvider::class,
            \Illuminate\Redis\RedisServiceProvider::class,
            \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
            \Illuminate\Session\SessionServiceProvider::class,
            \Illuminate\Translation\TranslationServiceProvider::class,
            \Illuminate\Validation\ValidationServiceProvider::class,
            \Illuminate\View\ViewServiceProvider::class
        ];
    }



    public function generateApplicationServiceProviders()
    {
        return [ \App\Providers\AppServiceProvider::class,
            \App\Providers\AuthServiceProvider::class,
            // App\Providers\BroadcastServiceProvider::class,
            \App\Providers\EventServiceProvider::class,
            \App\Providers\RouteServiceProvider::class,];
    }
}
