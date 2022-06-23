<?php

namespace Packages\Documents\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
