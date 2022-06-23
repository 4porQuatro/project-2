<?php

namespace Packages\Store\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOptionTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];
}
