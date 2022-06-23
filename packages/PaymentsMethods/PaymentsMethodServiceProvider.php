<?php


namespace Packages\PaymentsMethods;


use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Packages\PaymentsMethods\App\Http\Controllers\Livewire\cms\payment_methods\Form;
use Packages\PaymentsMethods\App\Http\Controllers\Livewire\cms\payment_methods\Table;
use Packages\PaymentsMethods\App\Http\Controllers\Livewire\cms\providers\Form as FormApi;
use Packages\PaymentsMethods\App\Http\Controllers\Livewire\cms\providers\Table as PaymentMethodsApiTable;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\PaymentsMethods\App\Policies\PaymentMethodPolicy;

class PaymentsMethodServiceProvider extends ServiceProvider {

    protected $policies = [
        PaymentMethod::class => PaymentMethodPolicy::class,
    ];

    protected $livewire_components = [
        'cms.payment_methods.providers.table' => PaymentMethodsApiTable::class,
        'cms.payment_methods.providers.form'=>FormApi::class,
        'cms.payment_methods.form'=> Form::class,
        'cms.payment_methods.table'=>Table::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'payment_methods');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');

        //$this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'payment_methods');

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/Providers/Easypay/config/easypay.php', 'easypay');
        $this->mergeConfigFrom(__DIR__.'/Providers/Eupago/config/eupago.php', 'eupago');
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
