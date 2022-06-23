<?php


namespace App\Packages\Payment\Easypay;


use Illuminate\Support\ServiceProvider;

class EasyPayServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/easypay.php', 'easypay');
    }

    public function boot()
    {

    }
}