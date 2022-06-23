<?php

namespace Packages\Store\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'small_body',
        'body',
        'active',
        'promoted',
        'highlighted'
    ];

    protected $casts = [
        'active'=>'boolean',
        'promoted'=>'boolean',
        'highlighted'=>'boolean'
    ];
}
