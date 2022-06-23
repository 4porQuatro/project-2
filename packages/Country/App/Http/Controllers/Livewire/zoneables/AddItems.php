<?php

namespace Packages\Country\App\Http\Controllers\Livewire\zoneables;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Region;
use Packages\Country\App\Models\Zone;

class AddItems  extends Component {

    use AuthorizesRequests;
    use WithPagination;

    public $zone;
    public $country;
    public $region;
    public $show_regions = false;

    public function mount(Zone $zone)
    {
        $this->zone = $zone;
    }


    public function render()
    {
        return view('country::livewire.cms.zoneables.add_items', ['zoneables'=>$this->getAttachedZoneables()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getAttachedZoneables()
    {
        $existing_zoneables_countries = $this->zone->fresh()->countries->pluck('id')->toArray();
        $existing_zoneables_regions = $this->zone->fresh()->regions->pluck('id')->toArray();
        $countries = Country::whereNotIn('id', $existing_zoneables_countries);
        if(!empty($this->country)){
            $countries = $countries->whereTranslationLike('name', '%'.$this->country.'%');
        }
        if(!empty($this->region))
        {
            return $countries->whereHas('regions', fn($q)=>$q->whereNotIn('regions.id', $existing_zoneables_regions)
            ->where('regions.name', 'LIKE', '%'.$this->region.'%'))->with(['regions'=>fn($q)=>$q->whereNotIn('regions.id', $existing_zoneables_regions)
                ->where('regions.name', 'LIKE', '%'.$this->region.'%')])->paginate(20);
        }
        return $countries->with(['regions'=>fn($q)=>$q->whereNotIn('regions.id', $existing_zoneables_regions)])->paginate(20);
    }

    public function toogleRegionsCountries()
    {
        $this->show_regions = !$this->show_regions;
    }

    public function add(Country $country)
    {
        $this->zone->countries()->syncWithoutDetaching($country);
    }

    public function addRegion(Region $region)
    {
        $this->zone->regions()->syncWithoutDetaching($region);
    }


}
