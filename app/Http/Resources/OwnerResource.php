<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //Padrão de retorno de dados para a tabela owners
        $collection =  [
            // 'id' => $this->id,
            'name' => $this->name,
            'email' => is_null($this->email) ? "uninformed" : $this->email,
            'cpf_cnpj' => $this->cpf_cnpj,
            'telephone_number' => $this->telephone_number,
            'status' => $this->status,
            'gender' => $this->gender == 'f' ? 'female' : 'male',

            //Cria um formato de visualização do timestamp mais agradável para o retorno
            'created_at' => Carbon::make($this->created_at)->format("Y-m-d h:i"),
            'updated_at' => Carbon::make($this->updated_at)->format("Y-m-d h:i"),
        ];
        //percorre o array de veículos do proprietário que está sendo consultado
        foreach ($this->vehicles as $key => $vehicle) {
            $collection['vehicles'][$key] = [
                'id' => $vehicle->id,
                'model' => $vehicle->model,
                'brand' => $vehicle->brand,
                'license_plate' => $vehicle->license_plate,
                'model_date' => $vehicle->model_date,
                'fabrication_date' => $vehicle->fabrication_date,
                'created_at' => Carbon::make($vehicle->created_at)->format("Y-m-d h:i"),
                'updated_at' => Carbon::make($vehicle->updated_at)->format("Y-m-d h:i"),
            ];
        }

        return $collection;
    }
}
