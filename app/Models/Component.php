<?php

namespace App\Models;

use App\Interfaces\Fieldable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Orders\App\Models\Checkout;
use Packages\PaymentsMethods\App\Models\PaymentMethod;
use Packages\Store\app\Models\Product;

class Component extends Model implements Fieldable
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = ['is_template'=>'boolean'];

    public function fields()
    {
        return $this->morphMany(Field::class, 'fieldable')->ordered();
    }

    public function terms()
    {
        return $this->morphMany(Term::class, 'termable');
    }

    public function possibleComponentableTypes()
    {
        $possible_types = [
            null => __('cms.global'),
            Article::class => __('cms.article')
        ];

        if(env('APP_STORE'))
        {
            $possible_types = array_merge($possible_types, [
                Product::class=>__('store::cms.product'),
            ]);
        }
        if(env('APP_ORDERS'))
        {
            $possible_types = array_merge($possible_types, [
                Checkout::class=>__('order::cms.checkout'),
            ]);
        }
        if(env('APP_PAYMENT_METHODS'))
        {
            $possible_types = array_merge($possible_types, [
                PaymentMethod::class=>__('payment_methods::cms.payment_methods'),
            ]);
        }

        return $possible_types;
    }

    public function getTerms()
    {
        $data = new \stdClass();
        foreach($this->terms as $term)
        {
            $key=$term->key;
            $data->$key = $term->value;
        }
        return $data;
    }

    public function avaliableFields()
    {
        $field_types = [
            'text' => 'Campo de texto',
            'textarea-single'=>'Textarea sem editor',
            'textearea-editor'=>'Textarea com editor',
            'integer'=>'Campo para números inteiros',
            'date'=>'Campo de data',
            'select-single'=>'Select uma opção',
            'select-multiple'=>'Select multiplas opções',
            'checkbox'=>'Checkox',
            'option'=>'Option',
            'image'=>'Imagens',
            'doc'=>'Documentos',
            'video'=>'Videos',
            'internal_link'=>'Link interno',
            'menu'=>'Menu',
            'form'=>'Formulário',
            'texts-list'=>'Lista de textos',
            'articles-list'=>'Lista de artigos',
            'titles-texts-list'=>'Lista de textos com titulos',
            'category-list'=>'Lista de categorias',
            'tags-list'=>'Lista de tags'
        ];

        if(env('APP_STORE'))
        {
            $field_types = array_merge($field_types, [
                'products-list'=>'Lista de produtos',
                'attributes-list'=>'Lista de atributos'
            ]);
        }

        if(env('APP_DOCUMENTS'))
        {
            $field_types = array_merge($field_types, [
                'documents-list'=>'Lista de documentos (modelo)'
            ]);
        }

        if(env('APP_IMAGE_HOTSPOTS'))
        {
            $field_types = array_merge($field_types, [
                'image-hotspots'=>'Imagem com Hotspots'
            ]);
        }

        return $field_types;
    }

    public function hasFieldGroups()
    {
        return false;
    }
}
