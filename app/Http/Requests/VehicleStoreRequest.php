<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
        //Regras de validação da requisição HTTP
        return [
            "owner_id" => 'required|exists:owners,id',
            'model' => 'required',
            'brand' => 'required',
            'license_plate' => 'required|unique:vehicles,license_plate',
            'model_date' => 'required|string',
            'fabrication_date' => 'required|string'
        ];
    }
}
