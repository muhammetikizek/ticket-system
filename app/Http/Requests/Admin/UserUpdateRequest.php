<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $this->user->id
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:255'
            ],
            'is_admin' => [
                'nullable',
                'boolean'
            ],
            'store_ids' => [
                'nullable',
                'array'
            ],
        ];
    }
}
