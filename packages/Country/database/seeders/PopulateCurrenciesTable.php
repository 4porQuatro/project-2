<?php


namespace Packages\Country\database\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PopulateCurrenciesTable extends Seeder {

    public function run()
    {
        $file = base_path().'/packages/Country/database/seeders/currencies.json';
        $data = json_decode(file_get_contents($file), true);
        DB::table('currencies')->insertOrIgnore($this->transformToCurrenciesTable($data));
    }

    public function transformToCurrenciesTable($array)
    {
        $new_array = [];
        foreach($array as $item)
        {
            $new_array[] = [
                'name' => $item['name'],
                'name_plural'=>$item['namePlural'],
                'symbol'=>$item['symbol'],
                'symbol_native'=>$item['symbolNative'],
                'decimal_digits'=>$item['decimalDigits'],
                'code'=>$item['code'],
                'active'=>$item['code'] === 'EUR'
            ];
        }
        return $new_array;
    }


}
