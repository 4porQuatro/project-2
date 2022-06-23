<?php

namespace Packages\Reserved\App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CmsFormRequest;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Packages\Reserved\App\Constants\AddressesTypes;
use Packages\Reserved\App\Constants\FormTypes;
use Packages\Reserved\App\Models\Address;
use Packages\Reserved\App\Models\Customer;


class AddressesController extends Controller
{
    public function get($type)
    {
        $addresses = Customer::find(auth()->user()->id)->addresses()->where(['type'=>$type])->get();

        $prefix_columns = request()->has('prefix_columns') && request()->get('prefix_columns');

        return $addresses->map(function($item) use($prefix_columns, $type){
            $data = [];
            foreach($item->toArray() as $key=>$value)
            {
                if(in_array($key, ['id','name', 'nif', 'address','default','country_id', 'region_id', 'email', 'city', 'phone', 'post_code', 'post_code_prefix']))
                {

                    $new_key = $prefix_columns ? $type.'_'.$key : $key;
                    $data[$new_key] = $value;

                }

                if(in_array($key, ['country_id', 'region_id']))
                {
                    $new_key = $prefix_columns ? $type.'_'.str_replace('_id', '',$key) : $key;
                    $data[$new_key] = $value;
                }
            }
            return $data;
        });


    }


    public function store(CmsFormRequest $request)
    {
        //$this->authorize('store', Address::class);

        $form = Form::findOrFail($request->get('cms_form_id'));

        $address_type = $form->type == FormTypes::BILLING_ADDRESS ? AddressesTypes::BILLING : AddressesTypes::SHIPPING;
        $default_address = Customer::where('id', auth()->user()->id)->first()->addresses()->where('type', $address_type)->exists() ? false : true;

        $additional_data = request()->except('_token', 'cms_form_id', 'name', 'nif', 'address', 'post_code', 'post_code_prefix', 'region_id', 'country_id', 'phone', 'email', 'city');

        Customer::where('id', auth()->user()->id)->first()->addresses()->create(
            [
                'name'=>$request->name,
                'nif'=>$request->nif,
                'address'=>$request->address,
                'country_id'=>$request->country_id,
                'phone'=>$request->phone,
                'email'=>$request->email,
                'region_id'=>$request->region_id,
                'post_code'=>$request->get('post_code'),
                'post_code_prefix'=>$request->get('post_code_prefix'),
                'default'=>$default_address,
                'type'=>$address_type,
                'additional_data'=>$additional_data,
                'user_id'=>auth()->user()->id,
                'city'=>$request->city
            ]
        );

        if($request->ajax())
        {
            return response(__('reserved::cms.address_updated_with_success'), 201);
        }

        return redirect()->back()->with('success', true);
    }

    public function update(CmsFormRequest $request)
    {
        Validator::make($request->all(),[
            'address_id'=>'required|exists:addresses,id'
        ])->validate();

        $address = Address::findOrFail($request->address_id);

        $this->authorize('update', $address);
        $additional_data = request()->except('_token', 'cms_form_id', 'name', 'nif', 'address', 'post_code', 'post_code_prefix', 'region_id', 'country_id', 'phone', 'email', 'city');

        $address->update([
            'name'=>$request->name,
            'nif'=>$request->nif,
            'address'=>$request->address,
            'country_id'=>$request->country_id,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'region_id'=>$request->region_id,
            'post_code'=>$request->get('post_code'),
            'post_code_prefix'=>$request->get('post_code_prefix'),
            'additional_data'=>$additional_data,
            'user_id'=>auth()->user()->id,
            'city'=>$request->city
        ]);

        if($request->ajax())
        {
            return response(__('reserved::cms.address_updated_with_success'), 201);
        }

        return redirect()->back()->with('success', true);
    }

    public function toogleDefault(Request $request, Address $address)
    {
        $actual_default_address = Customer::where('id', auth()->user()->id)->first()->addresses()->where('type', $address->type)->where('default', true)->first();
        $actual_default_address->default = false;
        $actual_default_address->save();

        $address->default = true;
        $address->save();
        if(request()->ajax())
        {
            return response('success', 201);
        }

        return redirect()->back()->with('success', true);
    }

    public function destroy(Address $address)
    {
        if($address->user_id == auth()->user()->id)
        {

            if($address->default)
            {
                $new_default = Customer::find(auth()->user()->id)->addresses()->where('default', false)->where('type', $address->type)->where('id', '<>', $address->id)->first();
            }
            $address->delete();
            if(!empty($new_default))
            {
                $new_default->default = true;
                $new_default->save();
            }
        }

        if(request()->ajax())
        {
            return response('success', 201);
        }

        return redirect()->back()->with('success', true);

    }
}
