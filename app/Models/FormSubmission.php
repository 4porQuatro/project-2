<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['data_submited', 'form_data', 'form_url', 'input_types', 'locale'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function setDataSubmitedAttribute($value)
    {
        $this->attributes['data_submited'] = !empty($value) ? json_encode($value) : json_encode([]);
    }

    public function setFormDataAttribute($value)
    {
        $this->attributes['form_data'] = json_encode($value) ? json_encode($value) : json_encode([]);
    }

    public function setInputTypesAttribute($value)
    {
        $this->attributes['input_types'] = json_encode($value) ? json_encode($value) : json_encode([]);
    }

    public function getDataSubmitedAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getFormDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getInputTypesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getFieldTypesAttribute($value)
    {
        return json_decode($value, true);
    }


}
