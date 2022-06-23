<?php

namespace Packages\Store\app\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ExternalReference;
use Illuminate\Http\Request;
use Packages\Store\app\Http\Requests\api\AttributeFamilyRequest;
use Packages\Store\app\Models\Attribute;
use Packages\Store\app\Models\AttributeFamily;

class AttributeFamilyController extends Controller
{
    public function store(AttributeFamilyRequest $request)
    {
        foreach (config('translatable.locales') as $locale)
        {
            $data[$locale] = ['title' => $request->has($locale) && ! empty($request->get($locale)['title']) ? $request->get($locale)['title'] : $request->get('title'),];
        }
        $family = AttributeFamily::create($data);
        $family->attributes()->sync($request->attribute_identifiers);

        return response()->json($family->toArray(), 200);
    }

    public function update(AttributeFamilyRequest $request, $attribute_family)
    {
        $family = AttributeFamily::findOrFail($attribute_family);

        $data = [];
        foreach(config('translatable.locales') as $locale)
        {
            if(!empty($request->$locale) && !empty($request->get($locale)['title']))
            {
                $data[$locale] = [
                    'title'=>  $request->get($locale)['title'],
                ];
            }
        }
        $family->update($data);
        $family->attributes()->sync($request->attribute_identifiers);

        return response()->json($family->toArray(), 200);
    }

    /**
     * @param AttributeFamilyRequest $request
     * @param $identifier
     * @param $family
     */
    private function syncAttributes(AttributeFamilyRequest $request, $family): void
    {

        if ($request->has('identifier_attributes') && is_array($request->get('identifier_attributes')))
        {
            $attributes = [];
            foreach ($request->get('identifier_attributes') as $identifier)
            {
                $attributes[] = ExternalReference::where('external_referenceable_type', Attribute::class)->where('identifier', $identifier)->first()->external_referenceable_id;
            }
            $family->attributes()->sync($attributes);
        }
    }


}
