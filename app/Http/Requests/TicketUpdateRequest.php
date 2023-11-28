<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'store_id' => [
                'required',
                'exists:stores,id'
            ],
            'name' => [
                'required',
                Rule::unique('tickets')->ignore($this->ticket->id),
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'enabled' => [
                'required',
                'boolean'
            ],
            'times' => [
                'nullable',
                'array'
            ],
            'times.*.quantity' => [
                'required',
                'numeric',
                'min:1'
            ],
            'times.*.price' => [
                'required',
                'numeric'
            ],
        ];

        foreach ($this->input('times') as $index => $time) {
            $uniqueRule = Rule::unique('ticket_times', 'time')->where(function ($query) {
                return $query->where('ticket_id', $this->route('ticketId'));
            });
    
            if (isset($time['id'])) {
                $uniqueRule->ignore($time['id']);
            }
    
            $rules["times.$index.time"] = [
                'nullable',
                'date_format:H:i',
                $uniqueRule,
            ];
        }
    
    

        return $rules;
    }

    public function messages(): array
    {
        return [
            'times.*.time.unique' => 'The time has already been taken.',
            'times.*.time.date_format' => 'The time does not match the format H:i.',
            'times.*.time.required' => 'The time field is required.',
        ];
    }

    public function prepareForValidation()
    {
        $times = $this->input('times');
        foreach ($times as $index => $time) 
        {
            if (empty($time['time']) && empty($time['quantity']) && empty($time['price'])) {
                unset($times[$index]);
                continue;
            }
            $times[$index]['time'] = date('H:i', strtotime(explode(' - ', $time['time'])[0]));
            $times[$index]['price'] = (float) $time['price'];
        }
        $this->merge([
            'times' => $times,
        ]);
    }
}
