<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    use Translatable;

    protected $translatedAttributes = ['name'];

    //protected $with = ['translations'];

    public function taggables($class = null)
    {
        $class = empty($class) ? Article::class : $class;
        return $this->morphedByMany($class, 'taggable');
    }

    public function scopeMostUsed($query)
    {
        return $query->select('tags.id')
            ->join('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->selectRaw('count(taggables.tag_id) as aggregate')
            ->groupBy('tags.id')
            ->orderBy('aggregate', 'desc');
    }

    public function scopeUsed($query)
    {
        return $query->select('tags.id')
            ->join('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->selectRaw('count(taggables.tag_id) > 0')
            ->groupBy('tags.id');
    }
}
