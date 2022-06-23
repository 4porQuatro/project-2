<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'data'
    ];

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function getByName(string $name)
    {
        return self::byName($name)->firstOrFail();
    }

    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }
}
