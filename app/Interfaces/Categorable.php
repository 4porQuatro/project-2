<?php

namespace App\Interfaces;

interface Categorable {
    public function hasLevels();
    public function isArticable();
    public static function getMainSearchColumn();
}
