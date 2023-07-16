<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Bodega;
use App\Models\Bebida;

use Illuminate\Http\Request;
use App\Http\Requests\EgresoRequest;
use Illuminate\Http\Response;
use Exception;

use Illuminate\Support\Facades\DB;

class EgresoController extends Controller
{
    public function createEgreso(EgresoRequest $request){
        try{
            $bodegaId = $request->bodega_id;
            $cargamento = $request->cargamento;

            $egreso = new Egreso();
            $egreso->bodega_id = $bodegaId;
            $egreso->cargamento = json_encode($cargamento);
            $egreso->save();

            foreach($cargamento as $item){
                $bebida_id = $item["bebida_id"];
                $bebida_nombre = $item["bebida_nombre"];
                $cantidad = $item["cantidad"];

                $stockBodega = DB::table("stock_bodegas")
                    ->where("bodega_id", $bodegaId)
                    ->where("bebida_id", $bebida_id)
                    ->first();

                if ($stockBodega) {
                    DB::table('stock_bodegas')
                        ->where("bodega_id", $bodegaId)
                        ->where("bebida_id", $bebida_id)
                        ->update([
                            "cantidad" => $stockBodega->cantidad - $cantidad
                        ]);
                } else {
                    throw new Exception("La bebida $bebida_nombre no existe en la bodega $bodegaId");
                }
                $egreso->bebidas()->attach($item["bebida_id"], [
                    "nombre" => $item["bebida_nombre"],
                    "cantidad" => $item["cantidad"]
                ]);
            }
            return response()->json(["egreso" => $egreso], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function deleteEgreso(EgresoRequest $request){
        try{
            $id = $request->id;
            $egreso = Egreso::find($id);
            if($egreso){
                $cargamento = json_decode($egreso->cargamento);
                foreach($cargamento as $item){
                    $bebida_id = $item->bebida_id;
                    $cantidad = $item->cantidad;
                    $stockBodega = DB::table("stock_bodegas")
                        ->where("bodega_id", $egreso->bodega_id)
                        ->where("bebida_id", $bebida_id)
                        ->first();
                    if ($stockBodega) {
                        DB::table('stock_bodegas')
                            ->where("bodega_id", $egreso->bodega_id)
                            ->where("bebida_id", $bebida_id)
                            ->update([
                                "cantidad" => $stockBodega->cantidad + $cantidad
                            ]);
                    } else {
                        throw new Exception("La bebida $bebida_id no existe en la bodega $egreso->bodega_id");
                    }
                }
                $egreso->delete();
                return response()->json(["egreso" => $egreso], Response::HTTP_OK);
            }else{
                throw new Exception("El egreso $id no existe");
            }
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function viewAllEgreso(){
        try{
            $egresos = Egreso::all();
            return response()->json(["egresos" => $egresos], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
