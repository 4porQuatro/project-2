<?php
namespace Packages\Country\App\Http\Controllers\Livewire\currency;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Currency;

class Table extends Component {

    use AuthorizesRequests;
    use WithPagination;

    protected $listeners = ['rateAdded'=>'$refresh'];
    public $title;

    public function mount()
    {

    }

    public function render()
    {
        return view('country::livewire.cms.currency.table', ['currencies' => $this->getCurrencies()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getCurrencies()
    {
        $currencies = new Currency();
        if ( ! empty($this->title))
        {
            $currencies = $currencies->where('name', 'LIKE', '%' . $this->title . '%');
        }

        return $currencies->orderBy('active', 'desc')->orderBy('name', 'asc')->paginate(20);
    }

    public function toogleActive(Currency $currency)
    {
        if($currency->code !==  'EUR')
        {
            $currency->active = ! $currency->active;
            $currency->save();
        }
    }
}
