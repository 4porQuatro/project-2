<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    protected $fillable = ['name', 'slug','active'];
    protected $casts = [
        'active'=>'boolean'
    ];
}
