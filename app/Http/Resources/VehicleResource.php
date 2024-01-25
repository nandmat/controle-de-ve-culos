<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'brand' => $this->brand,
            'license_plate' => $this->license_plate,
            'model_date' => $this->model_date,
            'fabrication_date' => $this->fabrication_date,
            'created_at' => Carbon::make($this->created_at)->format("Y-m-d h:i"),
            'updated_at' => Carbon::make($this->updated_at)->format("Y-m-d h:i"),
            //Pega os dados do proprietário e armazena no array owner
            'owner' => [
                'name' => $this->owner->name,
                'cpf_cnpj' => $this->owner->cpf_cnpj,
                'telephone_number' => $this->owner->telephone_number,
                'email' => is_null($this->owner->email) ? 'uninformed' : $this->owner->email,
                'status' => $this->owner->status,
                'gender' => $this->owner->gender == 'f' ? 'female' : 'male',
                'created_at' => Carbon::make($this->owner->created_at)->format("Y-m-d h:i"),
                'updated_at' => Carbon::make($this->owner->updated_at)->format("Y-m-d h:i"),
            ]
        ];
    }
}
