<?php

namespace App\Classes\Providers;

use App\Models\Setting;

abstract class Provider {
    public function getDataProvider(string $class)
    {
        $settings = Setting::where('name', $this->getSettingName())->first();
        if(empty($settings))
        {
            $settings = Setting::create(['data'=>[], 'name'=>$this->getSettingName()]);
        }
        if($this->checkIfDataProviderExists($class, $settings))
        {
            $data = array_values( $settings->data );
            $key_for_the_setting = array_search($class, array_column($data, 'provider'));
            $setting = $data[$key_for_the_setting];
            unset($setting['provider']);
            return $setting;
        }
        return null;
    }

    private function checkIfDataProviderExists($class, $settings)
    {
        return !empty(array_column($settings->data, 'provider'))
            &&  in_array($class, array_column($settings->data, 'provider'));
    }

    public function getProviderName($class)
    {
        return isset($this->getAvaliableProviders()[$class]) ? $this->getAvaliableProviders()[$class] : 'undefined';
    }

    abstract public function getSettingName();
    abstract public function getAvaliableProviders();
}
