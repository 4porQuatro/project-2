<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiPatchData extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'identifier'];

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
