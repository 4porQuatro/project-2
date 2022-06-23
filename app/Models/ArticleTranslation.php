<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'small_body',
        'body',
        'link',
        'link_text',
        'active',
        'promoted'
    ];

    protected $casts = [
        'active'=>'boolean',
        'promoted'=>'boolean'
    ];

}
