<?php


namespace Packages\Store;


use Packages\Store\app\Http\Livewire\Cms\Attributes\Table as AttributesTable;
use Packages\Store\app\Http\Livewire\Cms\AttributeOptions\Table as AttributeOptionsTable;
use Packages\Store\app\Http\Livewire\Cms\AttributeFamilies\Table as AttributeFamiliesTable;
use Packages\Store\app\Http\Livewire\Cms\Products\Table as ProductsTable;
use Packages\Store\app\Http\Livewire\Cms\Products\Form as ProductForm;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\AttributeOption;
use Packages\Store\app\Models\Product;
use Packages\Store\app\Policies\AttributeFamilyPolicy;
use Packages\Store\app\Policies\AttributeOptionPolicy;
use Packages\Store\app\Policies\AttributePolicy;
use Packages\Store\app\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class StoreServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class => ProductPolicy::class,
        Attribute::class => AttributePolicy::class,
        AttributeOption::class => AttributeOptionPolicy::class,
        AttributeFamily::class => AttributeFamilyPolicy::class,
    ];

    protected $livewire_components = [
        'cms.attributes.table' => AttributesTable::class,
        'cms.attribute-options.table' => AttributeOptionsTable::class,
        'cms.attribute-families.table' => AttributeFamiliesTable::class,
        'cms.products.table' => ProductsTable::class,
        'cms.products.form' => ProductForm::class,
    ];

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'store');
        $this->loadRoutesFrom(__DIR__.'/routes/cms.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'store');

        // php artisan vendor:publish --tag=cart_js_assets
        $this->publishes([
            __DIR__.'/resources/js' => resource_path('js'),
        ], 'cart_js_assets');
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
