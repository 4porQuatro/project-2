<?php

namespace Packages\Voucher\app\Http\Controllers\Livewire\voucherables;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Packages\Store\app\Models\Product;
use Packages\Voucher\app\Models\Voucher;

class Table extends Component {

    use WithPagination;
    use AuthorizesRequests;

    public $voucher;
    public $term;
    public $show_attached_products = true;
    public $category;



    public function mount(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    public function render()
    {
        return view('voucher::livewire.cms.voucherables.table', ['items'=>$this->getVoucherables(), 'categories'=>$this->getCategories()]);
    }

    public function paginationView()
    {
        return 'components.cms.table.pagination';
    }

    public function getVoucherables()
    {
        return $this->getQuery()->paginate(20);
    }

    public function getQuery()
    {

        if($this->show_attached_products)
        {
           $products =$this->voucher->products()->where('parent_id', null);
        } else {
            $attached_products_ids = $this->voucher->products()->get()->pluck('id')->toArray();
            $products = Product::where('parent_id', null)->whereNotIn('id', $attached_products_ids);
        }
        if(!empty($this->term))
        {
            $term = '%'.$this->term.'%';
            $products = $products->whereTranslationLike('title', $term);
        }
        if(!empty($this->category))
        {
            $category = $this->category;
            $products = $products->whereHas('categories', function($q) use ($category) {
                $q->where('categories.id', $category);
            });
        }

        return $products;

    }

    public function toogleAttachedProducts()
    {
        $this->resetPage();
        $this->show_attached_products = !$this->show_attached_products;
    }

    public function addItem($id)
    {
       $this->voucher->products()->attach($id);
    }

    public function removeItem($id)
    {
        $this->voucher->products()->detach($id);
    }

    public function attachAllItems()
    {
        $products_ids = $this->getQuery()->get()->pluck('id')->toArray();
        $this->voucher->products()->syncWithoutDetaching($products_ids);
    }

    public function detachAllItems()
    {
        $products_ids = $this->getQuery()->get()->pluck('id')->toArray();
        $this->voucher->products()->detach($products_ids);
    }

    public function getCategories()
    {
        return Category::where('categorable', Product::class)->get();
    }


}
