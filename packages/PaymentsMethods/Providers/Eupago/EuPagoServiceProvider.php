<?php


namespace App\Packages\Payment\Eupago;


use Illuminate\Support\ServiceProvider;

class EuPagoServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/eupago.php', 'eupago');
    }

    public function boot()
    {

    }
}