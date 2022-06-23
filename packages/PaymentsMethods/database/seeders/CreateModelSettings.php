<?php

namespace Packages\PaymentsMethods\database\seeders;

use App\Models\Component;
use App\Models\Layout;
use App\Models\ModelSetting;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Packages\Orders\tests\Mocks\Article;
use Packages\PaymentsMethods\App\Models\PaymentMethod;

class CreateModelSettings extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $component = Component::create(['name'=>'Detalhes do pagamento', 'componentable_type'=>PaymentMethod::class, 'path'=>'payment_methods::front.examples.details_payment']);
        $section = Section::create(['component_id'=>$component->id, 'name'=>'Detalhes do pagamento', ]);

        $model_setting = ModelSetting::create(['name'=>'Pagamentos', 'model'=>PaymentMethod::class, 'allowed_fields'=>[], 'layout_id'=>Layout::first()->id]);
        $model_setting->sections()->sync([$section->id]);
    }

    public function runInverse()
    {
        $component = Component::where('componentable_type', PaymentMethod::class)->first();
        $component->sections->each(function($item){
            $item->delete();
        });
        ModelSetting::where('model', PaymentMethod::class)->get()->each(function($m){
            $m->delete();
        });
    }



}
