<?php


namespace Packages\Country\database\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PopulateCountriesTable extends Seeder {

    public function run()
    {
        $data_path = base_path().'/vendor/stefangabos/world_countries/data/countries';

        $folders = array_diff(scandir($data_path), array('..','.'));
        $first_iteration = true;
        foreach($folders as $folder)
        {
            if($folder !== '_combined')
            {
                $data = json_decode(file_get_contents($data_path . '/' . $folder . '/countries.json'), true);
                if ($first_iteration)
                {
                    $first_iteration = false;
                    DB::table('countries')->insertOrIgnore($this->transformToCountriesTable($data));
                }
                DB::table('country_translations')->insertOrIgnore($this->transformToCountryTranslationTable($data, $folder));
            }
        }

        File::copyDirectory(base_path('vendor/stefangabos/world_countries/data/flags'), public_path('img/cms/flags'));
    }

    public function transformToCountriesTable($array)
    {
        $new_array = [];
        foreach($array as $item)
        {
            $new_array[] = ['id'=>$item['id'], 'code'=>$item['alpha2'], 'alpha3'=>$item['alpha3']];
        }
        return $new_array;
    }

    public function transformToCountryTranslationTable($array, $locale)
    {
        $new_array = [];
        foreach($array as $item)
        {
            $new_array[] = ['country_id'=>$item['id'], 'locale'=>$locale, 'name'=>$item['name']];
        }
        return $new_array;
    }
}
