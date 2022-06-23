<?php
namespace Packages\Country;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Packages\Country\App\Http\Controllers\Livewire\tax\TaxWidget;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Tax;
use Packages\Country\App\Policies\CountryPolicy;
use Packages\Country\App\Http\Controllers\Livewire\country\Table as CountryTable;
use Packages\Country\App\Http\Controllers\Livewire\region\Table as RegionTable;
use Packages\Country\App\Policies\TaxPolicy;
use Packages\Country\App\Http\Controllers\Livewire\country\Widget as CountryWidget;
use Packages\Country\App\Http\Controllers\Livewire\zones\Table as ZoneTable;
use Packages\Country\App\Http\Controllers\Livewire\zoneables\Table as ZoneableTable;
use Packages\Country\App\Http\Controllers\Livewire\zoneables\AddItems as ZoneableAddItems;
use Packages\Country\App\Http\Controllers\Livewire\currency\Table as CurrencyTable;
use Packages\Country\App\Http\Controllers\Livewire\currency\Rate as CurrencyRate;



class CountryServiceProvider extends ServiceProvider {

    protected $policies = [
        Country::class => CountryPolicy::class,
        Tax::class => TaxPolicy::class,
    ];

    protected $livewire_components = [
        'cms.country.table' => CountryTable::class,
        'cms.region.table'=> RegionTable::class,
        'cms.tax.widget'=>TaxWidget::class,
        'cms.country.widget'=>CountryWidget::class,
        'cms.zones.table'=>ZoneTable::class,
        'cms.zoneables.table'=>ZoneableTable::class,
        'cms.zoneables.add_items'=>ZoneableAddItems::class,
        'cms.currency.table'=>CurrencyTable::class,
        'cms.currency.rate'=>CurrencyRate::class


    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'country');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'country');

    }

    public function register()
    {
        $this->registerPolicies();
        $this->registerLivewireComponents();
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
