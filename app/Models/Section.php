<?php

namespace App\Models;

use App\Classes\Front\Data\ComponentData;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = [
        'data',
        'active'
    ];

    protected $fillable = [
        'name',
        'component_id'
    ];

    protected $guarded = [];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function pages()
    {
        return $this->morphedByMany(Page::class, 'sectionable');
    }

    public function layouts()
    {
        return $this->morphedByMany(Layout::class, 'sectionable');
    }

    public function getFrontData()
    {
        return (new ComponentData($this->component, $this->data))->getData();
    }

    public function getFrontTerms()
    {
        return (new ComponentData($this->component, $this->data))->getTerms();
    }

    public function headerLayout()
    {
        return $this->belongsTo(Layout::class, 'id', 'header_section_id');
    }

    public function footerLayout()
    {
        return $this->belongsTo(Layout::class, 'id', 'footer_section_id');
    }

    public function scopeBelongToLayout($q)
    {
        return $q->whereHas('headerLayout')->orWhereHas('footerLayout')->orWhereHas('layouts');
    }

    public function scopeActive($q)
    {
        return $q->whereTranslation('active', true, app()->getLocale());
    }
}
