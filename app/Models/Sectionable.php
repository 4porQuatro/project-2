<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Sectionable extends MorphPivot implements Sortable
{
    use SortableTrait;

    protected $table = 'sectionables';
    public $sortable = [
        'order_column_name' => 'priority',
        'sort_when_creating' => true,
    ];

    public $fillable = [
        'grid_id'
    ];

    public function grid()
    {
        return $this->belongsTo(Grid::class);
    }

}
