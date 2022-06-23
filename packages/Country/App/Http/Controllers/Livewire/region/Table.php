<?php


namespace Packages\Country\App\Http\Controllers\Livewire\region;


use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;

class Table extends Component {

    use WithPagination;

    public $country;

    protected $listeners = ['taxAdded'=>'$refresh'];

    public function mount(Country $country)
    {
        $this->country = $country;
    }

    public function render()
    {
        return view('country::livewire.cms.region.table', ['regions'=>$this->getRegions()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getRegions()
    {
        return $this->country->regions()->paginate(20);
    }

    public function toogleActive(Region $region)
    {
        $region->active = ! $region->active;
        if($region->active && !$region->country->active)
        {
            $country = $region->country;
            $country->active = true;
            $country->save();
        }
        $region->save();
    }
}

