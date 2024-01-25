<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleStoreRequest;
use App\Http\Requests\VehicleUpdateRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Owner;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    protected $vehicle;
    //Injeção de dependência do model Vehicle
    public function __construct(Vehicle $vehicle)
    {
        //Atribuindo o vehicle ao atributo da classe vehicle;
        $this->vehicle = $vehicle;
    }

    //Retorna todos os veículos cadastrados
    public function index()
    {
        $vehicles = $this->vehicle->all();
        return VehicleResource::collection($vehicles);
    }

    //Cadastro de novos veículos
    public function store(VehicleStoreRequest $request)
    {
        try {
            $data = $request->all();

            $vehicle = $this->vehicle->create($data);
            //padrão de retorno para os dados do veículo recém cadastrado
            return new VehicleResource($vehicle);
        } catch (Exception $e) {
            //tratamento de erros: registra o local do erro e retorna uma response no padrão
            //json com a mensagem fornecidade pelo objeto Exception, bem com o status da requisição
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(string $id)
    {
        //Procura o veículo pelo ID, se não achar, encerra a requisição;
        $vehicle = $this->vehicle->findOrFail($id);
        //retorna o veículo no padrão de retorno da resource;
        return new VehicleResource($vehicle);
    }

    public function update(VehicleUpdateRequest $request, string $id)
    {
        //Procura o veículo a ser atualizado pelo ID do veículo;
        $vehicle = $this->vehicle->find($id);
        //Atribui a variável data o conteúdo da requisição
        $data = $request->all();
        //Atualiza os dados do veículo
        $vehicle->update($data);
        //Retorna o veículo no padrão dentro do retorno da resource;
        return new VehicleResource($vehicle);
        try {
        } catch (Exception $e) {
            //Registro do erro da Exception
            Log::error($e);
            //Retorno no formato JSON do erro da requisiçã HTTP
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    //deletar veículos da base de dados por ID
    public function destroy(string $id)
    {
        try {
            $vehicle = $this->vehicle->findOrFail($id);
            $vehicle->delete();
            return response()->json([], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
