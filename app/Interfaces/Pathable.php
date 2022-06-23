<?php


namespace App\Interfaces;


use Illuminate\Database\Eloquent\Collection;

interface Pathable
{
    /**
     * Returns the path used in MenuItem.php
     * @return string
     */
    public function path();

    /**
     * Returns a array with the format: ['id'=>'name']
     * @return array
     */
    public function getPathables();

    /**
     * Returns the preview path
     * @return string
     */
    public function previewPath();
}
