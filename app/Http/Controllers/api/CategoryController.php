<?php

namespace App\Http\Controllers\api;

use App\Classes\Slug\CreateSlug;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\CategoryRequest;
use App\Models\ApiPatchData;
use App\Models\Article;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\ExternalReference;
use Illuminate\Http\Request;
use Packages\Store\app\Models\Product;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request, $type)
    {
        $this->authorize('store', Category::class);
        auth()->user()->apiPatchData()->create(['identifier'=>'create_category_'.$type, 'data'=>$request->all()]);
        $category_data = $request->except('_token', 'identifier');

        $category_data = [
            'categorable'=>$this->generateModelPath($type),
            'level'=> $this->defineLevel($request->get('parent_identifier')),
            'parent_id'=>$request->parent_identifier ?? null,
            'fields'=>[]
        ];

        $slug = $request->slug ?? (new CreateSlug(CategoryTranslation::class, $request->name))->create();

        foreach(config('translatable.locales') as $locale)
        {
            $category_data[$locale] = [
                'name'=> $request->has($locale) && !empty($request->get($locale)['name']) ? $request->get($locale)['name'] : $request->name,
                'slug'=>$slug
            ];
        }
        $category = Category::create($category_data);

        return response()->json($category, 200);
    }

    public function update(CategoryRequest $request, $type, $category)
    {
        $this->authorize('update', Category::class);
        auth()->user()->apiPatchData()->create(['identifier'=>'update_category_'.$type, 'data'=>$request->all()]);
        $category = Category::findOrFail($category);
        $category_data = [
            'categorable'=>$this->generateModelPath($type),
            'level'=> $this->defineLevel($request->get('parent_identifier')),
            'parent_id'=>$this->defineParentId($request->get('parent_identifier')),
            'fields'=>[]
        ];
        foreach(config('translatable.locales') as $locale)
        {
            if(!empty($request->$locale) && !empty($request->get($locale)['name']))
            {
                $category_data[$locale] = [
                    'name'=>  $request->get($locale)['name'],
                ];
            }
        }
        $category->update($category_data);

        return response()->json($category, 200);
    }

    public function destroy($type, $identifier)
    {
        $this->authorize('delete', Category::class);
        auth()->user()->apiPatchData()->create(['identifier'=>'delete_category_'.$type, 'data'=>['destroy']]);
        $external_reference = ExternalReference::where('identifier',$identifier)->where('external_referenceable_type', Category::class)->first();
        $category = $external_reference->externalReferenceable;
        $external_reference->delete();
        $category->delete();

        return response()->json(['status'=>'The record was sucessfuly deleted'], 200);
    }

    private function defineParentId($external_parent_id)
    {
        if(!empty($external_parent_id))
        {
            $external_reference = $this->getParent($external_parent_id);
            if(empty($external_reference))
                return null;

            return $external_reference->id;
        }
        return null;
    }


    private function defineLevel($external_parent_id)
    {
        $parent = $this->getParent($external_parent_id);
        return !empty($parent) ? $parent->level+1 : 0;
    }

    /**
     * @param $external_parent_id
     * @return mixed
     */
    private function getParent($parent_id)
    {

        return !empty($parent_id) ? Category::where('id', $parent_id)->first() : null;
    }

    private function generateModelPath($type)
    {
        $data = [
            'products'=>Product::class,
            'articles'=>Article::class,
        ];

        return $data[$type];
    }

}
