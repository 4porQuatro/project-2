<?php

namespace Packages\Store\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Packages\Store\app\Models\Product;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductFacebookCatalogExport implements FromCollection , WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('parent_id', null)->get();
    }

    public function map($product): array
    {
        $product_seo = $product->seo;
        $availability = $product->stock > 0 ? 'in stock' : 'out of stock';
        $price = $product->final_price.' EUR';
        $link = $product->path();
        $image_link = !empty($product->images) ? env('APP_URL').'/storage/'.$product->images[0]['path'] : '';

        return [
            $product->id,
            $product->title,
            $product_seo->description,
            $availability,
            'new',
            $price,
            $link,
            $image_link,
            config('app.name')
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'brand'
        ];
    }
}
