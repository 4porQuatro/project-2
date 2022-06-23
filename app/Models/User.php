<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'images',
        'profile_data',
        'profile_fields',
        'profile_input_types'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public $types = ['cms', 'member'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        $images_array = json_decode($value, true);
        return $images_array ?? [];
    }

    public function getProfileDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getProfileFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getProfileInputTypesAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     *  Roles that belong to the user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function hasRoleById($role_id)
    {
        return  $this->roles()->where('id', $role_id)->exists();
    }

    public function cmsAllowed()
    {
        return $this->type === 'cms';
    }

    public function isSuperUser()
    {
        return $this->roles->contains('name', 'sudo');
    }

    public function apiPatchData()
    {
        return $this->hasMany(ApiPatchData::class);
    }

    /**
     * Builder to get user permissions query.
     * @return Builder
     */
    public function permissions()
    {
        $roles_ids = $this->roles->pluck('id')->toArray();

        return Permission::whereHas('roles', function ($q) use ($roles_ids){
            $q->whereIn('roles.id', $roles_ids);
        })->distinct('id');
    }

    /**
     * Check if user has a specific permission.
     * @param  string  $permission_name
     * @return boolean
     */
    public function hasPermission(String $permission_name)
    {
        return $this->permissions()->where(['name'=>$permission_name])->exists();
    }
}
