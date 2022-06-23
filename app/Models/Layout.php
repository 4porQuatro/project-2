<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;

    const DEFAULT_PATH = 'front.core.layout';

    public $fillable = [
        'name',
        'header_section_id',
        'footer_section_id',
        'default',
        'path',
    ];

    protected $casts = [
        'default'=>'boolean',
    ];

    public function grids()
    {
        return $this->hasMany(Grid::class);
    }

    public function header()
    {
        return $this->hasOne(Section::class, 'id', 'header_section_id');
    }

    public function footer()
    {
        return $this->hasOne(Section::class, 'id', 'footer_section_id');
    }

    public function scopeDefault($query)
    {
        return $query->where('default', true);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path ?? self::DEFAULT_PATH;
    }

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable')->as('sectionable')->using(Sectionable::class)->withPivot(['id', 'grid_id']);
    }

    public static function getReadableName($plural = true)
    {
        return $plural ? 'Layouts' : 'Layout';
    }
}
