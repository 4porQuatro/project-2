<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldTranslation extends Model
{
    protected $fillable = [
        'label',
        'placeholder',
        'options'
    ];


    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function getOptionsAttribute($value)
    {
        return !empty($value) ? json_decode($value, true) : [];
    }
}
