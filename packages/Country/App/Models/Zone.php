<?php


namespace Packages\Country\App\Models;


use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Packages\Country\database\factories\ZoneFactory;

class Zone extends Model {

    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = [
        'active'=>'boolean',
        'undeletable'=>'boolean'
    ];

    protected static function newFactory()
    {
        return ZoneFactory::new();
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function zoneables()
    {
        return $this->hasMany(Zonable::class);
    }

    public function countries()
    {
        return $this->morphedByMany(Country::class, 'zonable');
    }

    public function regions()
    {
        return $this->morphedByMany(Region::class, 'zonable');
    }

}
