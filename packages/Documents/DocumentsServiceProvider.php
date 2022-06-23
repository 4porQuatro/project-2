<?php


namespace Packages\Documents;

use Illuminate\Support\ServiceProvider;
use Packages\Documents\App\Models\Document;
use Packages\Documents\App\Policies\DocumentPolicy;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Packages\Documents\App\Http\Livewire\Cms\Documents\Table as DocumentsTable;

class DocumentsServiceProvider extends ServiceProvider {

    protected $policies = [
        Document::class => DocumentPolicy::class,
    ];

    protected $livewire_components = [
        'cms.documents.table' => DocumentsTable::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'documents');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'documents');
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
