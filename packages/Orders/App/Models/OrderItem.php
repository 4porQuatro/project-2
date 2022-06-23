<?php


namespace Packages\Orders\App\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Orders\database\factories\OrderItemFactory;

class OrderItem extends Model {

    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return OrderItemFactory::new();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function setOriginalItemableDataAttribute($value)
    {
        $this->attributes['original_itemable_data'] = is_array($value) ? json_encode($value): $value;
    }

    public function getOriginalItemableDataAttribute($value)
    {
        return json_decode($value, true);
    }
}
