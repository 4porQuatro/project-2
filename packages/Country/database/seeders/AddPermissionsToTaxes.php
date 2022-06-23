<?php

namespace Packages\Country\database\seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AddPermissionsToTaxes extends Seeder
{

    public $methods = [
        ['name' => 'index', 'label'=>'Listar'],
        ['name' => 'show', 'label'=>'Ver'],
        ['name' => 'store', 'label'=>'Criar'],
        ['name' => 'update', 'label'=>'Atualizar'],
        ['name' => 'destroy', 'label'=>'Apagar']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_group = PermissionGroup::create(['name'=>'tax', 'label'=>'Imposto sobre produtos']);
        $role = $this->getRole();
        foreach($this->methods as $method)
        {
            $permission = Permission::create(['name'=>'tax_'.$method['name'], 'label'=>$method['label'], 'group_id'=>$permission_group->id]);
            $role->permissions()->attach($permission->id);

        }
    }

    public function runInverse()
    {
        $permission_group = PermissionGroup::where(['name' => 'tax'])->first();
        $role = $this->getRole();
        $role->permissions()->detach($permission_group->permissions->pluck('id')->toArray());
        $permission_group->delete();
    }

    private function getRole()
    {
        $role = Role::find(1);
        if(empty($role))
        {
            $role = Role::first();
        }
        return $role;
    }

}
