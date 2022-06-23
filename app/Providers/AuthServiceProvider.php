<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Component;
use App\Models\Field;
use App\Models\FieldGroup;
use App\Models\Form;
use App\Models\Layout;
use App\Models\ModelSetting;
use App\Models\Page;
use App\Models\Role;
use App\Models\Section;
use App\Models\Setting;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\FieldGroupPolicy;
use App\Policies\FieldPolicy;
use App\Policies\FormPolicy;
use App\Policies\LayoutPolicy;
use App\Policies\ModelSettingPolicy;
use App\Policies\PagePolicy;
use App\Policies\RolePolicy;
use App\Policies\SectionPolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Page::class => PagePolicy::class,
        Component::class => ComponentPolicy::class,
        Field::class => FieldPolicy::class,
        Section::class => SectionPolicy::class,
        Article::class => ArticlePolicy::class,
        Category::class => CategoryPolicy::class,
        Setting::class => SettingPolicy::class,
        Layout::class => LayoutPolicy::class,
        ModelSetting::class => ModelSettingPolicy::class,
        Form::class => FormPolicy::class,
        FieldGroup::class => FieldGroupPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
