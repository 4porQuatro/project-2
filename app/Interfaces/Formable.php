<?php


namespace App\Interfaces;


interface Formable {

    public function formTypes();
    public function formRequiredFields();
    public function formSettingsByType();
    public function getEndPointForm($form_type);
}
