<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OwnerStoreRequest extends FormRequest
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
        $rules =  [
            'name' => [
                'required',
            ],
            'cpf_cnpj' => [
                'required',
                'unique:owners,cpf_cnpj',
                'regex:/^[0-9]{11,14}$/',
            ],
            'telephone_number' => [
                'required'
            ],
            'gender' => [
                'required',
                'max:1',
            ]
        ];

        if (!is_null($this->email)) {
            $rules['email'] = [
                'email'
            ];
        }
        return $rules;
    }

    public function messages(): array
{
    return [
        'name.required' => 'O campo nome é obrigatório.',
        'cpf_cnpj.required' => 'O campo CPF/CNPJ é obrigatório.',
        'cpf_cnpj.unique' => 'O CPF/CNPJ já está em uso.',
        'cpf_cnpj.max' => 'O CPF/CNPJ deve ter no máximo :max caracteres.',
        'telephone_number.required' => 'O campo número de telefone é obrigatório.',
        'gender.required' => 'O campo gênero é obrigatório.',
        'gender.max' => 'O campo gênero deve ter no máximo :max caractere.',
        'email.email' => 'O formato do e-mail é inválido.',
    ];
}
}
