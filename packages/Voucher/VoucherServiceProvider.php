<?php

namespace Packages\Voucher;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Packages\Voucher\app\Http\Controllers\Livewire\vouchers\Table;
use Packages\Voucher\app\Models\Voucher;
use Packages\Voucher\app\Policies\VoucherPolicy;
use Packages\Voucher\app\Http\Controllers\Livewire\voucherables\Table as VoucherableTable;

class VoucherServiceProvider extends ServiceProvider {

    protected $policies = [Voucher::class => VoucherPolicy::class,];
    protected $livewire_components = [
        'cms.vouchers.table'=>Table::class,
        'cms.voucherables.table'=> VoucherableTable::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'voucher');
        $this->loadRoutesFrom(__DIR__ . '/routes/cms.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'voucher');
    }


    public function register()
    {
        $this->registerPolicies();
        $this->registerLivewireComponents();
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value)
        {
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
