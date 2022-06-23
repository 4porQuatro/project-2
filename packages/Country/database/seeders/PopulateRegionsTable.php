<?php


namespace Packages\Country\database\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Packages\Country\App\Models\CountryTranslation;
use Packages\Country\App\Models\Region;

class PopulateRegionsTable extends Seeder {

    public function run()
    {
        $file = base_path().'/packages/Country/database/seeders/regions_world.json';
        $data = json_decode(file_get_contents($file), true);
        DB::table('regions')->insertOrIgnore($this->transformToRegionsTable($data));
        //Não foi possível criar traduções para o presente modulo. Não se conseguiu optimizar o query para inserção dos dados na base de dados.
        //Eventualmente poderá funcionar melhor criar a tabela de traduções a posteriori.
    }

    public function transformToRegionsTable($array)
    {
        $new_array = [];
        foreach($array as $item)
        {
            $array_item = ['country_code'=>strtolower($item['countryShortCode'])];

            $region_array = [];
            foreach($item['regions'] as $region)
            {

                if(isset($region['shortCode']))
                {
                    $region_array[] = array_merge($array_item, ['code'=>strtolower($region['shortCode']), 'name'=>$region['name']]);
                }
            }
            $new_array = array_merge($new_array, $region_array);
        }
        return $new_array;
    }


}
