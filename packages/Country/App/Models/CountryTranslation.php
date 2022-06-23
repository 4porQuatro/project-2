<?php


namespace Packages\Country\App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Country\database\factories\CountryFactory;

class CountryTranslation extends Model {
    protected $fillable = ['name'];
}
