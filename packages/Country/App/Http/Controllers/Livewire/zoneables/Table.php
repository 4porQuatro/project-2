<?php

namespace Packages\Country\App\Http\Controllers\Livewire\zoneables;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Classes\ZonableInterface;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Zone;

class Table extends Component {

    use AuthorizesRequests;
    use WithPagination;

    public $zone;
    public $title;

    public function mount(Zone $zone)
    {
        $this->zone = $zone;
    }


    public function render()
    {
        return view('country::livewire.cms.zoneables.table', ['zoneables'=>$this->getAttachedZoneables()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getAttachedZoneables()
    {
        $zonables = $this->zone->zoneables();
        if(!empty($this->title)){
            $zonables = $zonables->whereTranslationLike('name', '%'.$this->title.'%');
        }
        return $zonables->paginate(20);
    }

    public function remove($zonable)
    {
        $model = $zonable['zonable_type']::find($zonable['zonable_id']);
        $model->zones()->detach($this->zone);
    }

}
