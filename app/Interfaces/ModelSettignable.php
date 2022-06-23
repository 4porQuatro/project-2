<?php


namespace App\Interfaces;


interface ModelSettignable
{
    /**
     * Returns the array of available fields
     * @return array
     */
    public static function getModelSettingsFields();
}
