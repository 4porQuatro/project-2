<?php
namespace Packages\Orders;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Packages\Orders\App\Http\Controllers\Livewire\cms\order\Table as OrdersTable;
use Packages\Orders\App\Http\Controllers\Livewire\cms\order_item\Table as OrderItemsTable;
use Packages\Orders\App\Models\Checkout;
use Packages\Orders\App\Models\Order;
use Packages\Orders\App\Observers\OrderObserver;
use Packages\Orders\App\Policies\CheckoutPolicy;
use Packages\Orders\App\Policies\OrderPolicy;
use Packages\Orders\App\Http\Controllers\Livewire\cms\checkout\Table as CheckoutTable;
use Packages\Orders\App\Http\Controllers\Livewire\cms\providers\invoice\Form as ProviderInvoiceForm;
use Packages\Orders\App\Http\Controllers\Livewire\cms\providers\invoice\Table as ProviderInvoiceTable;

class OrderServiceProvider extends ServiceProvider {

    protected $policies = [
        Order::class => OrderPolicy::class,
        Checkout::class => CheckoutPolicy::class
    ];

    protected $livewire_components = [
        'cms.orders.table' => OrdersTable::class,
        'cms.order_items.table' => OrderItemsTable::class,
        'cms.checkout.table'=> CheckoutTable::class,
        'cms.provider.invoice.form'=> ProviderInvoiceForm::class,
        'cms.provider.invoice.table'=> ProviderInvoiceTable::class,

    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'order');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'order');
        Order::observe(OrderObserver::class);

    }

    public function register()
    {
        $this->registerPolicies();
        $this->registerLivewireComponents();
        $this->mergeConfigFrom(__DIR__.'/App/Providers/Invoice/Moloni/config/moloni.php', 'moloni');
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
