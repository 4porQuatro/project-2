<?php

namespace Packages\Store\app\Http\Controllers\api;

use App\Classes\Slug\CreateSlug;
use App\Http\Controllers\Controller;
use App\Models\ExternalReference;
use Astrotomic\Translatable\Validation\RuleFactory;
use Packages\Store\app\Http\Requests\api\AttributeRequest;
use Packages\Store\app\Models\Attribute;

class AttributesController extends Controller
{
    public function store(AttributeRequest $request)
    {
        $data = [
            'unique_per_product'=>$request->get('unique_per_product') ? true : false,
            'swatch_type'=>$request->get('swatch_type') ?? null,
            'admin_title'=>(new CreateSlug(Attribute::class, $request->get('title'), 'admin_title'))->create()
        ];

        foreach(config('translatable.locales') as $locale)
        {
            $data[$locale] = [
                'title'=> $request->has($locale) && !empty($request->get($locale)['title']) ? $request->get($locale)['title'] : $request->title,
            ];
        }

        $attribute = Attribute::create($data);
        //$attribute->externalReference()->create($request->only('identifier'));

        return response()->json($attribute, 200);
    }

    public function update(AttributeRequest $request, $attribute)
    {
        $attribute = Attribute::findOrFail($attribute);

        $attribute_data = [];
        foreach(config('translatable.locales') as $locale)
        {
            if(!empty($request->$locale) && !empty($request->get($locale)['title']))
            {
                $attribute_data[$locale] = [
                    'title'=>  $request->get($locale)['title'],
                ];
            }
        }

        $attribute->update($attribute_data);

        return response()->json($attribute, 200);
    }

    public function destroy($attribute)
    {
        $this->authorize('delete', new Attribute());
        auth()->user()->apiPatchData()->create(['identifier'=>'delete_attribute', 'data'=>[$attribute]]);
        Attribute::find($attribute)->delete();

        return response()->json(['status'=>'The record was sucessfuly deleted'], 200);
    }


}
