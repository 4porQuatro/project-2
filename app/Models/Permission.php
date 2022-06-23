<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'group_id',
        'label'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'group_id' => 'integer'
    ];

    /**
     *  The group that this permission belongs to
     */
    public function group()
    {
        return $this->belongsTo(PermissionGroup::class, 'group_id');
    }

    /**
     *  The roles that this permission is assigned
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
