<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador.
use App\Models\Bodega;
use App\Models\Traspaso;
use App\Models\Bebida;

use Illuminate\Http\Request;
use App\Http\Requests\TraspasoRequest;
use Illuminate\Http\Response;
use Exception;

// DB para realizar consultas y operaciones directas en la base de datos.
use Illuminate\Support\Facades\DB;

// Controlador del modelo "Traspaso".
class TraspasoController extends Controller
{
    public function createTraspaso(TraspasoRequest $request){
        try {
            // Obtencion de la "bodega_id" de origen y destino y del "cargamento" desde el cuerpo de la solicitud HTTP.
            $bodegaOrigenId = $request->bodega_origen_id;
            $bodegaDestinoId = $request->bodega_destino_id;
            $cargamento = $request->cargamento;
            // Creacion de un nuevo registro de "Traspaso", al cual se le asigna la informacion de la bodega de origen, destino y el cargamento.
            $traspaso = new Traspaso();
            $traspaso->bodega_origen_id = $bodegaOrigenId;
            $traspaso->bodega_destino_id = $bodegaDestinoId;
            $traspaso->cargamento = json_encode($cargamento);
            // Guardado del registro en la base de datos.
            $traspaso->save();

            // Iteracion sobre cada elemento del arreglo "cargamento", para obtener el id de la bebida y la cantidad que llego.
            foreach($cargamento as $item){
                // Extraccion y asignacion de los valores "bebida_id" y "cantidad" del elemento actual.
                $bebida_id = $item["bebida_id"];
                $bebida_nombre = $item["bebida_nombre"];
                $cantidad = $item["cantidad"];
                // Verificacion de existencia previa de la bebida($bebida_id) en la bodega($bodegaId).
                $stockBodegaOrigen = DB::table("stock_bodegas")
                    ->where("bodega_id", $bodegaOrigenId)
                    ->where("bebida_id", $bebida_id)
                    ->first();

                // En caso de que la bebida ya exista en la bodega, se actualiza la cantidad restando la cantidad previa menos la nueva.
                if ($stockBodegaOrigen) {
                    // Verificacion para no dejar la bodega en negativo.
                    $cantidadDisponible = $stockBodegaOrigen->cantidad;
                    // Si la cantidad disponible es mayor o igual a la cantidad que se desea traspasar, se realiza el traspaso.
                    if($cantidadDisponible >= $cantidad){
                    // Acceso a la tabla de "stock_bodegas".
                    DB::table('stock_bodegas')
                        // Condicion de consulta para filtrar el registro por el valor de "bodega_id".
                        ->where("bodega_id", $bodegaOrigenId)
                        // Condicion de consulta para filtrar el registro por el valor de "bebida_id".
                        ->where("bebida_id", $bebida_id)
                        // Actualizacion del registro, restando la cantidad previa menos la nueva.
                        ->update([
                            "cantidad" => $cantidadDisponible - $cantidad
                        ]);
                }else{
                    throw new Exception("No hay suficiente cantidad de ".$bebida_nombre." en la bodega de origen");
                }
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
                            "cantidad" => $cantidad,
                            "nombre" => $bebida_nombre
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
