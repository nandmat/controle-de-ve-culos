<?php

namespace App\Http\Controllers;

use App\Http\Requests\OwnerStoreRequest;
use App\Http\Requests\OwnerUpdateRequest;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\VehicleResource;
use App\Models\Owner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    protected $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function index()
    {
        $owner = Owner::all();

        return OwnerResource::collection($owner);
    }

    public function show(string $id)
    {
        $owner = Owner::find($id);

        return new OwnerResource($owner);
    }
    public function store(OwnerStoreRequest $request)
    {
        try {
            $data = $request->all();
            $data['email'] = is_null($request->email) ? null : $request->email;
            $owner = $this->owner->create($data);

            return response()->json([new OwnerResource($owner)]);
        } catch (Exception $e) {
            Log::error($e);

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(OwnerUpdateRequest $request, string $id)
    {
        try {

            $owner = Owner::findOrFail($id);

            $data = $request->all();

            $owner->update($data);

            return new OwnerResource($owner);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(string $id)
    {
        try {
            Owner::where('id', $id)->delete();

            return response()->json([], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    //Busca veículos por proprietário;
    //parâmetros de consulta: name, email, cpf_cnpj;
    public function getVehiclesByOwner(Request $request)
    {
        try {
            $parameters = $request->all();

            //consulta sql para busca de veículos por proprietário
            //é passado uma função dentro da cláusula where da consulta
            //resultando assim num escopo para passar parâmetros de consultas personalizados
            //fazemos a verificação da existência do parâmetro antes de consultá-lo;
            //com a função with(), conseguimos trazer os veículos relacionados a este proprietário;
            //firstOrFail() busca o proprietário, mas caso não encontra, encerra a requisição, caindo
            //no bloco catch();
            $owner = $this->owner->where(function ($query) use ($parameters) {
                if (isset($parameters['name'])) {
                    $query->where('id', $parameters['name']);
                }
                if (isset($parameters['email'])) {
                    $query->where('email', $parameters['email']);
                }
                if (isset($parameters['cpf_cnpj'])) {
                    $query->where('cpf_cnpj', $parameters['cpf_cnpj']);
                }
            })->with(['vehicles'])->firstOrFail();

            return new OwnerResource($owner);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getCountVehiclesByGender()
    {
        try {
            // atribui a uma variavel o valor do select por genero
            $request = $this->owner->select('gender')
                //faz a contagem dos registro de veículos
                ->withCount('vehicles')
                //faz o agrupamento dos dados por id, name e gender
                ->groupBy('id', 'name', 'gender')
                //busca os registros no banco
                ->get();

            //Verificação se existe registro, se não, retorna o erro no padrão JSON;
            if ($request->isEmpty()) {
                return response()->json(['error' => 'Não foram encontrados registros'], 400);
            }

            //variaveis iniciais para a contagem de veículos por genero;
            $femaleVehicles = 0;
            $maleVehicles = 0;

            //percore a variavel request para adição dos valores nas variaveis acima;
            foreach ($request as $owner) {
                //verifica o genero e atribui o valor a variavel correta
                if ($owner->gender == 'f') {
                    $femaleVehicles = $femaleVehicles + $owner->vehicles_count;
                }

                if ($owner->gender == 'm') {
                    $maleVehicles = $maleVehicles + $owner->vehicles_count;
                }
            }
            //faz o retorno da requisição no padrão JSON da contagem de veículos por genero;
            return response()->json([
                'male_vehicles_count' => $maleVehicles,
                'female_vehicles_count' => $femaleVehicles
            ]);
        } catch (Exception $e) {
            //Tratamento de erros padrão em todo o projeto
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
