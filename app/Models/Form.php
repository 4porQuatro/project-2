<?php

namespace App\Models;

use App\Interfaces\Fieldable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model implements Fieldable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'can_see_answears'=>'boolean',
        'can_add_fields'=>'boolean',
        'apply_recaptcha'=>'boolean'
    ];

    public function fields()
    {
        return $this->morphMany(Field::class, 'fieldable');
    }

    public function fieldGroups()
    {
        return $this->morphMany(FieldGroup::class, 'field_groupable');
    }

    public function getFieldGroupsWithFields()
    {
        return $this->fieldGroups()->with(['fields' => function($q){
            $q->ordered();
        }])->ordered()->get();
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function getEndPointAttribute()
    {
        if ( ! empty($this->formable))
        {
            return $this->formable->getEndPointForm($this->type);
        }
        return route('form.submit.default');
    }

    public function formable()
    {
        return $this->morphTo();
    }

    public function getCmsFormIdAttribute()
    {
        return $this->id;
    }

    public function avaliableFields()
    {
        return [
            'text'=>'cms.field_text',
            'textarea-single'=>'cms.textarea-single',
            'integer'=>'cms.integer',
            'date'=>'cms.date',
            'checkbox'=>'cms.checkbox',
            'select-single'=>'cms.select-single',
            'select-multiple'=>'cms.select-multiple',
            'doc'=>'cms.doc'
        ];
    }

    //TODO::A Eliminar no futuro
    public function setEmailReceiversAttribute($value)
    {
        $this->attributes['email_receivers'] = json_encode($value);
    }
    //TODO::A Eliminar no futuro
    public function getEmailReceiversAttribute($value)
    {
        return json_decode($value, true);
    }

    public function hasFieldGroups()
    {
        return $this->fieldGroups()->exists();
    }
}
