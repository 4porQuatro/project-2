<?php


namespace Packages\Reserved\App\Models;

use App\Models\User;
use Packages\Reserved\App\Constants\AddressesTypes;
use Packages\Reserved\database\factories\CustomerFactory;


class Customer extends User
{
    public $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'images',
        'profile_data',
        'profile_fields',
        'profile_input_types'
    ];
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    public function getProfileDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getProfileFieldsAttribute($value)
    {
        return json_decode($value, true);
    }

//    public function setProfileInputTypesAttribute($value)
//    {
//        $this->attributes['profile_input_types'] = json_encode($value) ? json_encode($value) : json_encode([]);
//    }

    public function getProfileInputTypesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function billingAddresses()
    {
        return $this->addresses()->where('type', AddressesTypes::BILLING);
    }

    public function shippingAddresses()
    {
        return $this->addresses()->where('type', AddressesTypes::SHIPPING);
    }

    public function billingAddress()
    {
        return $this->billingAddresses()->where('default', true)->first();
    }

    public function shippingAddress()
    {
        return $this->shippingAddresses()->where('default', true)->first();
    }

    public function reservedArea()
    {
        return $this->belongsTo(ReservedArea::class);
    }
}
