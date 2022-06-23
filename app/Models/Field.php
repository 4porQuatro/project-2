<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Field extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    protected $guarded = [];
    public $types = ['text', 'textarea-single','textearea-editor', 'integer', 'date', 'select-single', 'select-multiple', 'checkbox', 'option', 'image', 'doc', 'video','articles-list', 'menu', 'category-list','form', 'products-list', 'texts-list', 'titles-texts-list', 'documents-list', 'internal_link', 'tags-list', 'attributes-list', 'image-hotspots'];
    public $avaliable_rules = [
        'required'=>'cms.required_rule',
        'date'=>'cms.date_rule',
        'email'=>'cms.email_rule',
        'unique:users'=>'cms.unique_users_rule',
        'confirmed'=>'cms.confirmed_rule',
        'nif_rule'=>'cms.nif_rule',
        'postal_code_rule'=>'cms.postal_code_rule',
    ];
    public $translatedAttributes = ['label', 'placeholder', 'options'];
    protected $casts = [
        'editable'=>'boolean'
    ];

    /**
     * The sortable library data for this model
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    public function fieldable()
    {
        return $this->morphTo();
    }

    public function fieldGroup()
    {
        return $this->belongsTo(FieldGroup::class);
    }

    public function setRulesAttribute($value)
    {
        $this->attributes['rules'] = json_encode($value);
    }

    public function getRulesAttribute($value)
    {
        return !empty($value) ? json_decode($value, true) : [];
    }


    public static function getAvaliableFields($model)
    {
        try {
            $avaliable_fields = (new $model)->avaliableFields();

        } catch(\Exception $e)
        {
            throw new \ErrorException('Deve implementar a interface Fieldable no modelo');
        }
        $static = new static;
        foreach($avaliable_fields as $key=>$field)
        {
            if(! in_array($key, $static->types))
            {
                unset($avaliable_fields[$key]);
            }
        }
        return $avaliable_fields;
    }

    public static function getTypeFieldsWithOptions()
    {
        return [
            'select-single',
            'select-multiple'
        ];
    }

    public function getEditableOptions()
    {
        $editable_options = [];

        if(auth()->user()->isSuperUser())
        {
            foreach ($this->options as $key=>$value)
            {
                $editable_options[] = [$key, $value];
            }
        }
        else
        {
            foreach ($this->options as $value)
            {
                $editable_options[] = $value;
            }
        }

        return $editable_options;
    }

}
