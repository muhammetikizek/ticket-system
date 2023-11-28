<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'storeId' => [
                'required',
                'integer',
                'exists:stores,id'
            ],
            'ticketId' => [
                'required',
                'integer',
                'exists:tickets,id'
            ],
            'ticketTimeId' => [
                'required_if:ticketId,!=,null',
                'integer',
                'exists:ticket_times,id',
            ],
            'quantity' => [
                'required',
                'numeric',
                'min:1',
            ]
        ];
    }

    public function messages()
    {
        return [
            'storeId.required' => 'Store is required',
            'storeId.integer' => 'Store must be an integer',
            'storeId.exists' => 'Store must be exists',
            'ticketId.required' => 'Bilet seçimi zorunludur.',
            'ticketId.integer' => 'Ticket must be an integer',
            'ticketId.exists' => 'Ticket must be exists',
            'ticketTimeId.required_if' => 'Lütfen ilk önce bilet seçiniz.',
            'ticketTimeId.integer' => 'Ticket time must be an integer',
            'ticketTimeId.exists' => 'Ticket time must be exists',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity must be a number',
            'quantity.min' => 'Minimum 1 adet bilet alabilirsiniz.',
        ];
    }
}
