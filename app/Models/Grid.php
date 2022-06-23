<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    use HasFactory;

    public $fillable = [
        'layout_id',
        'name'
    ];

    public function layout()
    {
        return $this->belongsTo(Layout::class);
    }
}
