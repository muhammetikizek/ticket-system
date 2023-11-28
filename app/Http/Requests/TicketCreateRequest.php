<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
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
                'exists:stores,id'
            ],
            'name' => [
                'required',
                'unique:tickets,name'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'times' => ['required', 'array'],
            'times.*.time' => ['required', 'date_format:H:i'],
            'times.*.quantity' => ['required', 'numeric'],
            'times.*.price' => ['required', 'numeric'],
        ];
    }
}
