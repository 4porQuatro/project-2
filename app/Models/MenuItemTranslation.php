<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    protected $fillable = [
        'name',
        'url',
        'active'
    ];

    protected $casts = [
        'active'=>'boolean'
    ];
}
