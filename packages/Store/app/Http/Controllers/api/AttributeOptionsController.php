<?php

namespace Packages\Store\app\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ExternalReference;
use Illuminate\Http\Request;
use Packages\Store\app\Http\Requests\api\AttributeOptionRequest;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeOption;

class AttributeOptionsController extends Controller
{
    public function store(AttributeOptionRequest $request)
    {
        foreach(config('translatable.locales') as $locale)
        {
            $data[$locale] = [
                'title'=> $request->has($locale) && !empty($request->get($locale)['title']) ? $request->get($locale)['title'] : $request->title,
            ];
        }
        $attribute = Attribute::find($request->get('attribute_identifier'));
        $attribute_option = $attribute->attributeOptions()->create($data);

        return response()->json($attribute_option, 200);

    }


    public function update(AttributeOptionRequest $request, $attribute_option)
    {

        $attribute_option = AttributeOption::find($attribute_option);
        $attribute_option_data = [];
        foreach(config('translatable.locales') as $locale)
        {
            if(!empty($request->$locale) && !empty($request->get($locale)['title']))
            {
                $attribute_option_data[$locale] = [
                    'title'=>  $request->get($locale)['title'],
                ];
            }
        }

        $attribute_option->update($attribute_option_data);

        return response()->json($attribute_option, 200);

    }

    public function destroy($attribute_option)
    {
        AttributeOption::findOrFail($attribute_option)->delete();
    }
}
