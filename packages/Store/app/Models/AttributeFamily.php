<?php

namespace Packages\Store\app\Models;

use App\Models\ExternalReference;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Store\database\factories\AttributeFamilyFactory;

class AttributeFamily extends Model
{
    use HasFactory;
    use Translatable;

    public $fillable = [
        'title'
    ];

    public $translatedAttributes = [
        'title',
    ];

    protected static function newFactory()
    {
        return AttributeFamilyFactory::new();
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }


    public function uniquePerProductAttributes()
    {
        return $this->attributes()->where('unique_per_product', true);
    }

    public function variantAttributes()
    {
        return $this->attributes()->where('unique_per_product', false);
    }

    public function hasAttributeById($attribute_id)
    {
        return  $this->attributes()->where('attribute_id', $attribute_id)->exists();
    }
    public function externalReference()
    {
        return $this->morphOne(ExternalReference::class, 'external_referenceable');
    }
}
