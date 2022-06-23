<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = ['label', 'value'];
    protected $guarded = [];

    public function termable()
    {
        return $this->morphTo();
    }

}
