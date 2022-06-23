<?php

namespace Packages\Voucher\app\Http\Requests;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Packages\Store\app\Http\Livewire\Cms\Products\Form;
use Packages\Voucher\app\Models\Voucher;

class VoucherRequest extends FormRequest{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'=>'required',
        ];
    }


    public function withValidator($validator)
    {
        $voucher = $this->getVoucher();
        $validator->after(function ($validator) use ($voucher) {
            $this->emptyVoucher($voucher, $validator);
            $this->validateExpirationDate($voucher, $validator);
        });
    }

    public function getVoucher()
    {
        return Voucher::where('code', $this->get('code'))->first();
    }

    /**
     * @param $voucher
     * @param $validator
     * @return void
     */
    private function emptyVoucher($voucher, $validator): void
    {
        if (empty($voucher))
        {
            $validator->errors()->add('code', __('voucher::app.code_invalid'));
        }
    }

    /**
     * @param $voucher
     * @param $validator
     * @return void
     */
    private function validateExpirationDate($voucher, $validator): void
    {
        if ( ! empty($voucher) && ! empty($voucher->expires_at) && Carbon::now()->greaterThan($voucher->expires_at))
        {
            $validator->errors()->add('code', __('voucher::app.voucher_expired'));
        }
    }


}
