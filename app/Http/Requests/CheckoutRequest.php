<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCustomer();
    }

    public function rules(): array
    {
        return [
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_address_id.required' => 'Alamat pengiriman wajib dipilih',
            'shipping_address_id.exists' => 'Alamat tidak valid',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $addressId = $this->input('shipping_address_id');

            if ($addressId) {
                $address = \App\Models\ShippingAddress::find($addressId);

                if (!$address || $address->user_id !== auth()->id()) {
                    $validator->errors()->add('shipping_address_id', 'Alamat tidak valid atau bukan milik Anda');
                }
            }
        });
    }
}
