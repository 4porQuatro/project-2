<?php

namespace Packages\Store\app\Http\Controllers\api;

use App\Classes\Slug\CreateSlug;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExternalReference;
use Illuminate\Http\Request;
use Packages\Store\app\Http\Requests\api\AttributeFamilyRequest;
use Packages\Store\app\Http\Requests\api\ProductRequest;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeFamily;
use Packages\Store\app\Models\AttributeOption;
use Packages\Store\app\Models\Product;
use Packages\Store\app\Models\ProductTranslation;

class ProductsController extends Controller
{

    public function index()
    {

        $products = new Product();
        if(request()->has('categories'))
        {

            $categories = request()->get('categories');
            $products = $products->whereHas('categories', function($q) use ($categories) {
                is_array($categories) ? $q->whereIn('categories.id', $categories) : $q->where('categories.id', $categories);
            });
        }
        if(request()->has('id'))
        {
            $products = $products->where('id', request()->get('id'));
        }
        if(request()->has('sku'))
        {
            $products = $products->where('sku', request()->get('sku'));
        }
        return response()->json($products->get(), 200);
    }

    public function store(ProductRequest $request)
    {

        $data = $this->generateProductDataCreation($request);
        //dd($data);
        $data_seo = $this->generateSeoData($data);

        $product = Product::create($data);

        if(empty($product->parent))
            $this->linkCategories($request, $product);

        if($request->has('attributes') && !empty($request->get('attributes')) && ! $product->has_variants)
        {
            $this->linkAttributeOptions($request, $product);
        }

        if($request->has('optionals') && !empty($request->get('optionals')))
        {
            $this->linkOptionals($request, $product);
        }

        $product->seo()->create($data_seo);

        return response()->json($product, 200);
    }

    public function update(ProductRequest $request, $product)
    {
        $product = Product::findOrFail($product);

        $data = $this->getRequestData($request);

        foreach ($data as $key => $result)
        {
            if (in_array($key, config('translatable.locales')))
            {
                foreach ($result as $column => $value)
                {
                    $product_translation = $product->translateOrNew($key);
                    $product_translation->{$column} = $value;
                    $product_translation->save();
                }
            }
        }
        $product->update($data);

        if (request()->has('categories') && empty($product->parent))
        {
            $this->linkCategories($request, $product);
        }

        if(request()->has('attributes'))
        {
            $this->linkAttributeOptions($request, $product);
        }

        if(request()->has('optionals'))
        {
            $this->linkOptionals($request, $product);
        }

        return response()->json($product, 200);
    }


    private function getModelByReference($class, $identifier)
    {
        return ExternalReference::where(['external_referenceable_type' => $class, 'identifier' => $identifier])->first()->externalReferenceable;
    }

    /**
     * @param ProductRequest $request
     * @param $product
     */
    private function linkCategories(ProductRequest $request, $product): void
    {
        $categories = $request->get('categories');
        foreach($categories as $cat)
        {
            $categories = array_unique(array_merge($categories, Category::where('id', $cat)->first()->getAllAscendents()->pluck('id')->toArray()));
        }

        $product->categories()->sync($categories);
    }

    /**
     * @param ProductRequest $request
     * @param $product
     */
    private function linkAttributeOptions(ProductRequest $request, $product): void
    {
        $attribute_options = $request->get('attributes');
        if(!empty($product->parent))
        {
            $product->parent->attributeOptions()->detach($product->attributeOptions->pluck('id')->toArray());
            $product->parent->attributeOptions()->attach($attribute_options);
        }
        $product->attributeOptions()->sync($attribute_options);


    }

    /**
     * @param ProductRequest $request
     * @param $product
     */
    private function linkOptionals(ProductRequest $request, $product): void
    {
        $optionals =$request->get('optionals');

        $product->optionals()->sync($optionals);
    }

    private function isParent($request)
    {
        return $request->has('is_parent') ? boolval($request->get('is_parent')) : false;
    }

    private function hasParentIdentifier($request)
    {
        return $request->has('parent_identifier') && !empty($request->get('parent_identifier')) ? true : false;
    }

    /**
     * @param ProductRequest $request
     * @return array
     */
    private function getRequestData(ProductRequest $request): array
    {
        $valid_fields = ['sku', 'ref', 'price', 'promoted_price', 'stock', 'title', 'small_body', 'body', 'active', 'shippment_length', 'shippment_weight', 'shippment_width', 'shippment_height'];
        $valid_fields = array_merge($valid_fields, config('translatable.locales'));
        $data = $request->only($valid_fields);
        return $data;
    }

    /**
     * @param ProductRequest $request
     * @return array
     */
    private function generateProductDataCreation(ProductRequest $request): array
    {
        $data = $this->getRequestData($request);
        $slug = (new CreateSlug(ProductTranslation::class, $request->get('title')))->create();

        foreach (config('translatable.locales') as $locale)
        {
            $data[$locale] = ['title' => $request->has($locale) && ! empty($request->get($locale)['title']) ? $request->get($locale)['title'] : $request->title, 'small_body' => $request->has($locale) && ! empty($request->get($locale)['small_body']) ? $request->get($locale)['small_body'] : $request->small_body, 'body' => $request->has($locale) && ! empty($request->get($locale)['body']) ? $request->get($locale)['body'] : $request->body, 'active' => $request->has($locale) && ! empty($request->get($locale)['active']) ? $request->get($locale)['active'] : $request->active, 'slug' => $slug];
        }


        $data['has_variants'] = $this->isParent($request);
        $data['attribute_family_id'] = $request->get('attribute_family_identifier');
        $data['parent_id'] = $request->get('parent_identifier') ?? null;
        return $data;
    }

    private function generateSeoData($data)
    {
        $data_seo = [];
        foreach (config('translatable.locales') as $locale)
            $data_seo[$locale] = ['title'=>$data['title']];

        return $data_seo;
    }




}
