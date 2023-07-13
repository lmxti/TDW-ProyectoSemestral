<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador.
use App\Models\Bodega;
use App\Models\Traspaso;
use App\Models\Bebida;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\TraspasoRequest;
use Exception;

// Controlador del modelo "Traspaso".
class TraspasoController extends Controller
{
    public function createTraspaso(TraspasoRequest $request){
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
                $traspaso->bebidas()->attach($item["bebida_id"], [
                    "nombre" => $item["bebida_nombre"],
                    "cantidad" => $item["cantidad"],
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            }
            return response()->json(["traspaso" => $traspaso], Response::HTTP_OK);
        }catch (Exception $e){
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteTraspaso(TraspasoRequest $request){
        try {
            // Busca el trasapaso en la base de datos utilizando el id del traspaso.
            $traspaso = Traspaso::find($request->id);
            // Asigna los valores de la bodega de origen y destino del traspaso.
            $bodegaOrigenId = $traspaso->bodega_origen_id;
            $bodegaDestinoId = $traspaso->bodega_destino_id;
            $cargamento = json_decode($traspaso->cargamento, true);
            // Recorre el cargamento del traspaso.
            foreach($cargamento as $item){
                $bebida_id = $item["bebida_id"];
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
                            "cantidad" => $stockBodegaOrigen->cantidad + $cantidad
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
                            "cantidad" => $stockBodegaDestino->cantidad - $cantidad
                        ]);
                }
            }

            $traspaso->delete();
            return response()->json(["traspaso" => $traspaso], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewAllTraspaso(TraspasoRequest $request){
        try {
            $traspasos = Traspaso::all();
            return response()->json(["traspasos" => $traspasos], Response::HTTP_OK);
        }catch (Exception $e){
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
