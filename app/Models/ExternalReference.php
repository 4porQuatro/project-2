<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalReference extends Model
{
    use HasFactory;

    protected $fillable = ['identifier'];

    public function externalReferenceable()
    {
        return $this->morphTo();
    }
}
