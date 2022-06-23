<?php

namespace Packages\Documents\App\Models;

use App\Models\Category;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Packages\Documents\database\factories\DocumentFactory;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Document extends Model implements Sortable
{
    use HasFactory;
    use Translatable;
    use SortableTrait;

    public $fillable = [
        'paths',
        'priority',
        'documentable_type',
        'documentable_id',
    ];

    public $translatedAttributes = [
        'name'
    ];

    protected static function newFactory()
    {
        return DocumentFactory::new();
    }

    public function setPathsAttribute($value)
    {
        $this->attributes['paths'] = json_encode($value);
    }

    public function getPathsAttribute($value)
    {
        $paths_array = json_decode($value, true);
        return $paths_array ?? [];
    }

    public function getPathAttribute()
    {
        $all_paths = $this->paths;

        return !empty($this->paths) ? array_shift($all_paths) : [];
    }

    public function documentable()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorable');
    }

    public function getReadableName($plural = true)
    {
        return $plural ? 'Documentos' : 'Documento';
    }
}
