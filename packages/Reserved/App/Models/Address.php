<?php

namespace Packages\Reserved\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Reserved\App\Constants\AddressesTypes;
use Packages\Reserved\database\factories\AddressFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nif',
        'email',
        'address',
        'post_code',
        'post_code_prefix',
        'phone',
        'city',
        'region_id',
        'country_id',
        'contact',
        'additional_data',
        'default',
        'type',
    ];

    protected $casts = [
        'default'=>'boolean'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return AddressFactory::new();
    }

    public function setAdditionalDataAttribute($value)
    {
        $this->attributes['additional_data'] = json_encode($value);
    }

    public function getAdditionalDataAttribute($value)
    {
        return !empty($value) ? json_decode($value, true) : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function types()
    {
        return [
            AddressesTypes::SHIPPING => 'reserved::cms.shipping_address',
            AddressesTypes::BILLING => 'reserved::cms.billing_address',
        ];
    }
}
