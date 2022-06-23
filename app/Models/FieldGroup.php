<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FieldGroup extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;
    use Translatable;

    public $translatedAttributes = [
        'name'
    ];

    protected $fillable = [
        'priority'
    ];

    /**
     * The sortable library data for this model
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    public function fieldGroupable()
    {
        return $this->morphTo();
    }

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
