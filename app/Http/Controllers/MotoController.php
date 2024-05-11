<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class MotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dadosMotos = Moto::all();
        $contador = $dadosMotos->count();

        return 'Motos: ' . $contador.$dadosMotos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dadosMotos = $request->all();
        $validarDados = Validator::make($dadosMotos, [
            'marca' => 'required',
            'modelo' => 'required',
            'cor' => 'required',
            'ano' => 'required',
        ]);

        if ($validarDados->fails()) {
            return 'Dados Inválidos.' . $validarDados->errors(true). 500;
        }

        $moto = Moto::create($dadosMotos);
        $motosCadastrar = moto::create($dadosMotos);
        if ($motosCadastrar) {
            return 'Dados Cadastrados com Sucesso' .response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return 'Dados não cadastrados.' .response()->json([], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $moto = Moto::find($id);
        if ($moto) {
            return 'Moto localizada.' . $moto .response()->json([], Response::HTTP_NO_CONTENT);
        } else {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dadosMotos = $request->all();
        $validarDados = Validator::make($dadosMotos, [
            'marca' => 'required',
            'modelo' => 'required',
            'cor' => 'required',
            'ano' => 'required',
        ]);

        if ($validarDados->fails()) {
            return 'Dados Inválidos. ' .$validarDados->error(true) . 500;
        }

        $moto = Moto::find($id);

        if (!$moto) {
            return 'DadoS não atualizados'. Response()->json([], Response::HTTP_NO_CONTENT);
        }
        else{
            return 'Dados atualizados com sucesso'. Response()->json([], Response::HTTP_NO_CONTENT);
        }

        $moto->marca = $dadosMotos['marca'];
        $moto->modelo = $dadosMotos['modelo'];
        $moto->cor = $dadosMotos['cor'];
        $moto->ano = $dadosMotos['ano'];

        $moto->save();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $moto = Moto::find($id);

        if (!$moto) {
            return 'A moto não foi encontrada.';
        }

        if ($moto->delete()) {
            return 'A moto foi deletada com sucesso!!';
        }

        return 'A moto não foi deletada.';
    }
}
