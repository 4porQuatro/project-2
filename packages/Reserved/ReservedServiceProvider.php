<?php


namespace Packages\Reserved;


use Packages\Reserved\App\Http\Middleware\ReservedAuth;
use Livewire\Livewire;
use Packages\Reserved\App\Models\Address;
use Packages\Reserved\App\Models\Customer;
use Packages\Reserved\App\Models\ReservedArea;
use Packages\Reserved\App\Policies\AddressPolicy;
use Packages\Reserved\App\Policies\CustomerPolicy;
use Packages\Reserved\App\Policies\ReservedAreaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Packages\Reserved\App\Http\Livewire\cms\reserved_area\Table as ReservedAreaTable;
use Packages\Reserved\App\Http\Livewire\cms\Customers\Table as CustomersTable;

class ReservedServiceProvider extends ServiceProvider {

    protected $policies = [
        ReservedArea::class => ReservedAreaPolicy::class,
        Address::class => AddressPolicy::class,
        Customer::class => CustomerPolicy::class
    ];

    protected $livewire_components = [
        'cms.reserved_area.table' => ReservedAreaTable::class,
        'cms.customers.table' => CustomersTable::class
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'reserved');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'reserved');

    }

    public function register()
    {
        $this->registerPolicies();
        $this->registerLivewireComponents();
        app('router')->aliasMiddleware('auth.reserved', ReservedAuth::class);
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
