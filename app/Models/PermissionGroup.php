<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label'
    ];

    /**
     *  Permissions that belong to this group
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'group_id');
    }

    public function scopeAvailableToUser($q)
    {
        $user_permissions_ids = auth()->user()->permissions()->get()->pluck('id')->toArray();

        return $q->whereHas('permissions', function ($query) use ($user_permissions_ids){
           $query->whereIn('id', $user_permissions_ids);
        })->with('permissions', function ($query) use ($user_permissions_ids){
            $query->whereIn('id', $user_permissions_ids);
        });
    }
}
