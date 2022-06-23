<?php

namespace Packages\Store\database\seeders;

use App\Models\ModelSetting;
use Illuminate\Database\Seeder;
use Packages\Store\app\Models\Product;

class ProductModelSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!ModelSetting::where('model', Product::class)->exists())
        {
            $this->create();
        }

        $model_setting = ModelSetting::where('model', Product::class)->first();

        foreach (Product::all() as $product)
        {
            $product->update(['model_setting_id'=>$model_setting->id]);
        }
    }

    public function create()
    {
        $product_model_setting = ModelSetting::create([
            'name'=>'geral',
            'model'=>Product::class,
            'allowed_fields'=>[],
        ]);
    }
}
