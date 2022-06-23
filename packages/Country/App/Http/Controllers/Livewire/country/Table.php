<?php


namespace Packages\Country\App\Http\Controllers\Livewire\country;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Currency;

class Table extends Component {

    use AuthorizesRequests;
    use WithPagination;

    protected $listeners = ['taxAdded'=>'$refresh'];
    public $active_currencies;
    public $name;
    public $currency;


    public function mount()
    {
        $this->active_currencies = Currency::active()->get();
    }

    public function render()
    {
        return view('country::livewire.cms.country.table', ['countries'=>$this->getCountries()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getCountries()
    {
        $countries = new Country;
        if(!empty($this->name))
        {
            $countries = $countries->where('name', 'LIKE', '%' . $this->name . '%');

        }
        $countries = $countries->orderByTranslation('name', 'asc')->paginate(20);
        $this->currency = $countries->pluck('currency_id', 'id')->toArray();
        return $countries;
    }

    public function toogleActive(Country $country)
    {
        $country->active = ! $country->active;
        $country->regions->each(function($item) use ($country) {
            $item->active = $country->active;
            $item->save();
        });
        $country->save();
    }

    public function changeCurrency(Country $country)
    {
        $country->currency_id = $this->currency[$country->id];
        $country->save();
    }


}

