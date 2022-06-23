<?php


namespace Packages\Country\App\Http\Controllers\Livewire\tax;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Country\App\Models\Country;
use Packages\Country\App\Models\Tax;

class TaxWidget extends Component {

    public $taxable;
    public $tax;

    protected $rules = [
        'tax' => 'required|numeric',
    ];

    public function mount(Model $taxable)
    {
        $this->taxable = $taxable;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveTax()
    {
        $validatedData = $this->validate();
        $this->taxable->taxes()->firstOrCreate()->update(['percentage'=>$this->tax]);
        $this->emitUp('taxAdded');
    }

    public function render()
    {
        return view('country::livewire.cms.tax.widget');
    }




}

