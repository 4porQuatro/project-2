<?php


namespace App\Classes\Locales;


use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CmsLocale
{
    public $available_locales = [];
    public $active_locale = null;

    public function __construct()
    {
        $this->setAvaiableLocales();
        $this->setActiveLocale();
    }

    private function setAvaiableLocales()
    {
        $this->available_locales = Cache::rememberForever('available_locales', function (){
            return Setting::getByName('available_locales')->data;
        });
    }

    private function setActiveLocale()
    {
        if(!session()->has('locale'))
        {
            $default_locale = array_key_first($this->available_locales);
            if($this->checkIfLocaleIsAvailable($default_locale))
            {
                session()->put('locale', $default_locale);
            }
        }

        $this->active_locale = session('locale');
    }

    private function resetAvaiableLocales()
    {
        Cache::forget('available_locales');
        Session::forget('locale');
        $this->setAvaiableLocales();
    }

    public function checkIfLocaleIsAvailable($locale)
    {
        if(array_key_exists($locale, $this->available_locales)){
            return true;
        }

        return false;
        //TODO: Throw exception here case doent exist?
    }

    public function setNewActiveLocale($locale)
    {
        session()->put('locale', $locale);
        $this->active_locale = session('locale');
    }

    public function getLocalesThatCanBeAdded()
    {
        return array_diff(config('translatable.avaiable_locales'), $this->available_locales);
    }

    public function addAvaiableLocale($new_locale)
    {
        $langs_settings = Setting::getByName('available_locales');

        $new_data = $langs_settings->data;
        $new_data[$new_locale] = $this->getLocalesThatCanBeAdded()[$new_locale];

        $langs_settings->update(['data'=>$new_data]);

        $this->resetAvaiableLocales();

        $this->createTranslations($new_locale);
    }

    public function removeAvaiableLocale($locale_to_remove)
    {
        $langs_settings = Setting::getByName('available_locales');

        $new_data = $langs_settings->data;
        unset($new_data[$locale_to_remove]);

        $langs_settings->update(['data'=>$new_data]);

        $this->resetAvaiableLocales();

        $this->deleteTranslations($locale_to_remove);
    }

    private function createTranslations($new_locale)
    {
        foreach ($this->getTranslationsTables() as $table)
        {
            $rows = $this->getRowsToTranslate($table, $new_locale);
            $translated_rows = $this->translateRows($rows, $new_locale);
            DB::table($table)->insert($translated_rows);
        }
    }

    private function deleteTranslations($locale_to_remove)
    {
        foreach ($this->getTranslationsTables() as $table)
        {
            $rows = $this->getRowsToDelete($table, $locale_to_remove);
            foreach ($rows as $row)
            {
                DB::table($table)->delete($row->id);
            }
            //TODO:Aqui é feito um foreach das rows porque nao estava a conseguir fazer delete de todas de uma vez, ao fazer delete($rows->pluck('id')->toArray()) apenas 1 linha era eliminada
        }
    }

    private function getTranslationsTables()
    {
        $tables = DB::select('SHOW TABLES');
        $data = [];
        $database = 'Tables_in_' . env('DB_DATABASE');
        foreach ($tables as $table)
        {
            if (strpos($table->$database, '_translations') !== false )
            {
                $data[] = $table->$database;
            }
        }

        return $data;
    }

    private function getRowsToTranslate($table, $new_locale)
    {
        if(empty(DB::table($table)->where('locale', $new_locale)->first()))
            return DB::table($table)->where('locale', $this->active_locale)->get();
        return [];
    }

    private function getRowsToDelete($table, $locale)
    {
        return DB::table($table)->where('locale', $locale)->get();
    }

    private function translateRows($rows, $new_locale)
    {
        $data = [];
        foreach ($rows as $row)
        {
            $row = collect($row)->toArray();
            unset($row['id']);
            $row['locale'] = $new_locale;
            if(isset($row['slug']))
            {
                $row['slug'] = $row['slug'].'-'.$new_locale;
            }
            /**
            if(isset($row['active']))
            {
                $row['active'] = false;
            }
             */

            $data[] = $row;
        }

        return $data;
    }

}
