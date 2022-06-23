<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSetting extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'allowed_fields',
        'model',
        'layout_id'
    ];

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Definições do modelo' : 'Definição do modelo';
    }


    public function setAllowedFieldsAttribute($value)
    {
        $this->attributes['allowed_fields'] = json_encode($value);
    }

    public function getAllowedFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public function mainSection()
    {
        return $this->sections()->whereHas('component', function($q){
            $q->where('componentable_type', Article::class);
        })->first();
    }

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }

}
