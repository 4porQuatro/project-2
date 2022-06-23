<?php

namespace Packages\shipping_methods\database\seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class AddShippingMethodArea extends Seeder
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
        $permission_group = PermissionGroup::create(['name'=>'shipping_method', 'label'=>'Metódos de envio']);
        $role = $this->getRole();
        foreach($this->methods as $method)
        {
            $permission = Permission::create(['name'=>'shipping_method_'.$method['name'], 'label'=>$method['label'], 'group_id'=>$permission_group->id]);
            $role->permissions()->attach($permission->id);

        }
    }

    public function runInverse()
    {
        $permission_group = PermissionGroup::where(['name' => 'shipping_method'])->first();
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
