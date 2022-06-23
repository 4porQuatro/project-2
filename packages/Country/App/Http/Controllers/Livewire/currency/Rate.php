<?php


namespace Packages\Country\App\Http\Controllers\Livewire\currency;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Currency;
use Packages\Country\App\Models\Tax;

class Rate extends Component {

    public $currency;
    public $rate;

    protected $rules = [
        'rate' => 'required|numeric',
    ];

    public function mount(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveRate()
    {
        $validatedData = $this->validate();
        if($this->currency->code !== 'EUR')
        {
            $this->currency->rate = $this->rate;
            $this->currency->save();
        }
        $this->emitUp('rateAdded');
    }

    public function render()
    {
        return view('country::livewire.cms.currency.rate');
    }




}
