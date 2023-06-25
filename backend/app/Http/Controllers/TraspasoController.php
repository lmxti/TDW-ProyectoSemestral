<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Bodega;
use App\Models\Traspaso;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class TraspasoController extends Controller
{
    public function createTraspaso(Request $request){
        try {
            $bodegaOrigenId = $request->bodega_origen_id;
            $bodegaDestinoId = $request->bodega_destino_id;
            $cargamento = $request->cargamento;

            $traspaso = new Traspaso();
            $traspaso->bodega_origen_id = $bodegaOrigenId;
            $traspaso->bodega_destino_id = $bodegaDestinoId;
            $traspaso->cargamento = json_encode($cargamento);

            $traspaso->save();

            foreach($cargamento as $item){
                $bebida_id = $item["bebida_id"];
                $bebida_nombre = $item["bebida_nombre"];
                $cantidad = $item["cantidad"];

                $stockBodegaOrigen = DB::table("stock_bodegas")
                    ->where("bodega_id", $bodegaOrigenId)
                    ->where("bebida_id", $bebida_id)
                    ->first();

                if ($stockBodegaOrigen) {
                    DB::table('stock_bodegas')
                        ->where("bodega_id", $bodegaOrigenId)
                        ->where("bebida_id", $bebida_id)
                        ->update([
                            "cantidad" => $stockBodegaOrigen->cantidad - $cantidad
                        ]);
                }

                $stockBodegaDestino = DB::table("stock_bodegas")
                    ->where("bodega_id", $bodegaDestinoId)
                    ->where("bebida_id", $bebida_id)
                    ->first();

                if ($stockBodegaDestino) {
                    DB::table('stock_bodegas')
                        ->where("bodega_id", $bodegaDestinoId)
                        ->where("bebida_id", $bebida_id)
                        ->update([
                            "cantidad" => $stockBodegaDestino->cantidad + $cantidad
                        ]);
                } else {
                    DB::table('stock_bodegas')
                        ->insert([
                            "bodega_id" => $bodegaDestinoId,
                            "bebida_id" => $bebida_id,
                            "cantidad" => $cantidad
                        ]);
                }
            }
            return response()->json(["traspaso" => $traspaso], Response::HTTP_OK);
        }catch (Exception $e){
            return response()->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
    
    public function viewAllTraspaso(){
        try {
            $traspasos = Traspaso::all();
            return response()->json(["traspasos" => $traspasos], Response::HTTP_OK);
        }catch (Exception $e){
            return response()->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
