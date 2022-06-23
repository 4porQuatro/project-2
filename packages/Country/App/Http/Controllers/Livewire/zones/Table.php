<?php

namespace Packages\Country\App\Http\Controllers\Livewire\zones;



use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;

class Table extends Component {

    use AuthorizesRequests;
    use WithPagination;


    public function render()
    {
        return view('country::livewire.cms.zones.table', ['zones'=>$this->getZones()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getZones()
    {
        return Zone::orderBy('name', 'asc')->paginate(20);
    }

    public function toogleActive(Zone $zone)
    {
        $zone->active = ! $zone->active;

        $zone->save();
    }

    public function delete(Zone $zone)
    {
        $this->authorize('viewAny', Country::class);
        $zone->delete();
    }

}
