<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'store_id' => [
                'required',
                'integer',
                'exists:stores,id'
            ],
            'code' => [
                'nullable'
            ],
            'sku' => [
                'nullable'
            ],
            'name' => [
                'required',
                'string',
                'unique:stores,name'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ],
            'price' => [
                'required',
                'min:0'
            ]
        ];
    }
}
