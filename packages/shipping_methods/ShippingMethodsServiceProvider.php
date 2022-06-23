<?php
namespace Packages\shipping_methods;

use Packages\Reserved\App\Http\Middleware\ReservedAuth;
use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Packages\shipping_methods\App\Http\Controllers\Livewire\cms\shipping_methods\Table;
use Packages\shipping_methods\App\Http\Controllers\Livewire\cms\shipping_prices\Table as ShippingPricesTable;
use Packages\shipping_methods\App\Http\Controllers\Livewire\cms\shipping_zones\Table as ShippingZonesTable;
use Packages\shipping_methods\App\Http\Controllers\Livewire\cms\shipping_zones\AddItems as ShippingZonesAddItems;

use Packages\shipping_methods\App\Models\ShippingMethod;
use Packages\shipping_methods\App\Policies\ShippingMethodPolicy;

class ShippingMethodsServiceProvider extends ServiceProvider {

    protected $policies = [
        ShippingMethod::class => ShippingMethodPolicy::class,
    ];

    protected $livewire_components = [
        'cms.shipping_methods.table' => Table::class,
        'cms.shipping_prices.table'=> ShippingPricesTable::class,
        'cms.shipping_zones.table'=> ShippingZonesTable::class,
        'cms.shipping_zones.add_items'=> ShippingZonesAddItems::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'shipping_methods');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        //$this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'shipping_methods');

    }

    public function register()
    {
        $this->registerPolicies();
        $this->registerLivewireComponents();
        //app('router')->aliasMiddleware('auth.reserved', ReservedAuth::class);
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    public function registerLivewireComponents()
    {
        foreach ($this->livewire_components as $key => $value)
        {
            Livewire::component($key, $value);
        }
    }
}
