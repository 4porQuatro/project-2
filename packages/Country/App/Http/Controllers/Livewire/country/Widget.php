<?php


namespace Packages\Country\App\Http\Controllers\Livewire\country;


use Livewire\Component;
use Packages\Country\App\Models\Country;

class Widget extends Component{

    public $country_id;
    public $country_name;
    public $region_id;
    public $countries;
    public $regions;


    public function mount()
    {
        $this->countries = Country::limit(10)->get();

    }

    public function render()
    {
        return view('country::livewire.cms.country.widget');
    }

    public function selectCountry($id, $name)
    {
        $this->country_id = $id;
        $this->country_name = $name;
    }

}
