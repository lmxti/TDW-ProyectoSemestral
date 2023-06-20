<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bodega;
use Illuminate\Http\Response;
use Exception;
use App\Http\Requests\BodegaRequest;

class BodegaController extends Controller
{
    public function createBodega(Request $request){
        try {
            $bodega = new Bodega();
            $bodega->nombre = $request->nombre;
            $bodega->save();
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewBodega(Request $request){
        try {
            $bodega = Bodega::find($request->id);
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updateBodega(Request $request){
        try {
            $bodega = Bodega::find($request->id);
            $bodega->nombre = $request->nombre;
            $bodega->save();
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteBodega(Request $request){
        try {
            $bodega = Bodega::find($request->id);
            $bodega->delete();
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewAllBodegas(Request $request){
        try {
            $bodegas = Bodega::all();
            return response()->json(["bodegas"=>$bodegas], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
