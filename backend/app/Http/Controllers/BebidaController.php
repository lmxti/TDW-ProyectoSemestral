<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bebida;
use Illuminate\Http\Response;
use Exception;
use App\Http\Requests\BebidaRequest;

class BebidaController extends Controller{


    // Para crear una bebida
    public function createBebida(BebidaRequest $request){
        try {
            $bebida = new Bebida();
            $bebida->nombre = $request->nombre;
            $bebida->sabor = $request->sabor;
            $bebida->tamano = $request->tamano;
            $bebida->save();
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewBebida(BebidaRequest $request){
        try {
            $bebida = Bebida::find($request->id);
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateBebida(BebidaRequest $request){
        try {
            $bebida = Bebida::find($request->id);
            $bebida->nombre = $request->nombre;
            $bebida->sabor = $request->sabor;
            $bebida->tamano = $request->tamano;
            $bebida->save();
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteBebida(BebidaRequest $request){
        try {
            $bebida = Bebida::find($request->id);
            $bebida->delete();
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewAllBebidas(BebidaRequest $request){
        try {
            $bebidas = Bebida::all();
            return response()->json(["bebidas"=>$bebidas], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
