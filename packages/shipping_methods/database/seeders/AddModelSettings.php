<?php


namespace Packages\shipping_methods\database\seeders;
use App\Models\Article;
use App\Models\ModelSetting;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AddModelSettings extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelSetting::create(['name'=>'Metódos de envio', 'model'=>Article::class, 'allowed_fields'=>["title","subtitle","small_body","images"]]);
    }

    public function runInverse()
    {
        ModelSetting::where('name', 'Metódos de envio')->get()->each(function($m){
            $m->delete();
        });
    }

}
