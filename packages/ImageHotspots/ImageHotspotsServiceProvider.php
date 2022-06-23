<?php


namespace Packages\ImageHotspots;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Packages\ImageHotspots\App\Http\Livewire\Cms\Hotspots\Table;
use Packages\ImageHotspots\App\Http\Livewire\Cms\ImageHotspots\Upload;

class ImageHotspotsServiceProvider extends ServiceProvider
{
    protected $livewire_components = [
        'cms.image-hotspots.upload' => Upload::class,
        'cms.hotspots.table' => Table::class
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'image_hotspots');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'image_hotspots');

        $this->publishes([
            __DIR__.'/config/image_hotspots.php' => config_path('image_hotspots.php'),
        ]);
    }

    public function register()
    {
        $this->registerLivewireComponents();

        $this->mergeConfigFrom(
            __DIR__.'/config/image_hotspots.php', 'image_hotspots'
        );
    }

    public function registerLivewireComponents()
    {
        foreach ($this->livewire_components as $key => $value)
        {
            Livewire::component($key, $value);
        }
    }
}
