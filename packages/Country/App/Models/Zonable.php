<?php

namespace Packages\Country\App\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Zonable extends MorphPivot {
    protected $table = 'zonables';

    public function relatedModel()
    {
        return $this->morphTo('zonable');
    }

}
