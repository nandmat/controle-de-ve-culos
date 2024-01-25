<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'required',
                'min:3'
            ],
            'cpf_cnpj' => [
                'required',
                "unique:owners,cpf_cnpj,$this->id,id"
            ],
            'telephone_number' => [
                'required'
            ],
            'gender' => [
                'required',
                'min:1'
            ],
            'status' => [
                'required',
                'boolean'
            ]
        ];

        if(!is_null($this->email)){
            $rules['email'] = [
                'email'
            ];
        }

        return $rules;
    }
}
