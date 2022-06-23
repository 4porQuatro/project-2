<?php


namespace Packages\Country\App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\App\Classes\ZonableInterface;
use Packages\Country\database\factories\CountryFactory;
use Packages\Country\database\factories\RegionFactory;

class Region extends Model implements ZonableInterface {

    use HasFactory;

    protected $fillable = ['code'];
    protected $casts = [
        'active'=>'boolean'
    ];

    protected static function newFactory()
    {
        return RegionFactory::new();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function taxes()
    {
        return $this->morphMany(Tax::class, 'taxable');
    }

    public function zones()
    {
        return $this->morphToMany(Zone::class, 'zonable');
    }

    public function defaultTax()
    {
        return $this->taxes->count() ? $this->taxes->first()->percentage : $this->country->defaultTax();
    }


    public function getName()
    {
        return $this->country->name.' - '.$this->name;
    }


    public function getFlag()
    {
        return $this->country->flag_image;
    }
}
