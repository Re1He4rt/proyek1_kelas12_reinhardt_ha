<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
            'shipping_address_id.required' => 'Alamat pengiriman harus dipilih',
            'shipping_address_id.exists' => 'Alamat pengiriman tidak valid',
        ];
    }
}
