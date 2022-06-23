<?php

namespace Packages\Voucher\app\Http\Controllers\Livewire\vouchers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Voucher\app\Models\Voucher;

class Table extends Component {

    use AuthorizesRequests;
    use WithPagination;

    public $term;

    public function mount()
    {

    }

    public function render()
    {
        return view('voucher::livewire.cms.vouchers.table', ['vouchers'=>$this->getVouchers()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getVouchers()
    {
        $voucher = new Voucher;
        if(!empty($this->term))
        {
            $term = '%'.$this->term.'%';
            $voucher = $voucher->where('name', 'LIKE', $term)->orWhere('code', 'LIKE', $term);
        }
        return $voucher->orderBy('created_at', 'desc')->paginate(20);
    }

    public function toogleActive(Voucher $voucher)
    {
        $this->authorize('update', $voucher);

        $voucher->active = ! $voucher->active;
        $voucher->save();
    }

    public function delete(Voucher $voucher)
    {
        $this->authorize('delete', $voucher);
        $voucher->delete();

    }
}
