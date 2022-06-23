<?php

namespace Packages\Orders\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Orders\database\factories\StatusHistoryFactory;

class StatusHistory extends Model {

    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return StatusHistoryFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
