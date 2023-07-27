<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador
use App\Models\Bodega;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Traspaso;

use Illuminate\Http\Request;
use App\Http\Requests\BodegaRequest;
use Illuminate\Http\Response;
use Exception;

use Illuminate\Support\Facades\DB;

// Controlador para el modelo 'Bodega', que se utiliza para manejar las solicitudes HTTP y ejecutar la logica correspondiente.  
class BodegaController extends Controller
{
    // Metodo para crear un registro de "Bodega".
    public function createBodega(BodegaRequest $request){
        try {
            // Creacion de nuevo registro de "Bodega".
            $bodega = new Bodega();
            // Asignacion de valores a los atributos del modelo.
            $bodega->nombre = $request->nombre;
            // Guardado del registro en la base de datos.
            $bodega->save();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para ver un registro de "Bodega" utilizando el id de la bodega.
    public function viewBodega(BodegaRequest $request){
        try {
            // Busqueda del registro de "Bodega" en la Base de datos utilizando el valor del campo "id" y asignacion en $bodega.
            $bodega = Bodega::find($request->id);
            // Retorno de respuesta HTTP exitosa en formato JSON con el contenido encontrado.
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para actualizar valores de un registro de "Bodega" utilizando el id de la bodega.
    public function updateBodega(BodegaRequest $request){
        try {
            // Busqueda del registro de "Bodega" en la Base de datos utilizando el valor del campo "id" y asignacion en $bodega.
            $bodega = Bodega::find($request->id);
            // Asignacion de valores a los atributos del modelo.
            $bodega->nombre = $request->nombre;
            // Guardado del registro en la base de datos.
            $bodega->save();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para eliminar un registro de "Bodega" utilizando el id de la bodega.
    public function deleteBodega(BodegaRequest $request){
        try {
            // Busqueda del registro de "Bodega" en la Base de datos utilizando el valor del campo "id" y asignacion en $bodega.
            $bodega = Bodega::find($request->id);

            if ($bodega) {

                // Variable que contiene todos los ingresos asociados a la bodega.
                $ingresos = Ingreso::where('bodega_id',$bodega->id)->get();
                foreach ($ingresos as $ingreso) {
                    $detallesIngreso = DB::table('detalle_ingresos')
                    ->select('ingreso_id')
                    ->where('ingreso_id', '=', $ingreso->id)
                    ->delete();
                }
                $ingresos->each->delete();

                // Variable que contiene todos los egresos asociados a la bodega.
                $egresos = Egreso::where('bodega_id',$bodega->id)->get();
                foreach ($egresos as $egreso){
                    $detalleEgreso = DB::table('detalle_egresos')
                    ->select('egreso_id')
                    ->where('egreso_id', '=', $egreso->id)
                    ->delete();
                }
                $egresos->each->delete();


                // Variable que contiene todos los traspasos realizados desde la bodega.
                $traspasos = Traspaso::where('bodega_origen_id',$bodega->id)->get();
                foreach ($traspasos as $traspaso){
                    $detalleTraspaso = DB::table('detalle_traspasos')
                    ->select('traspaso_id')
                    ->where('traspaso_id', '=', $traspaso->id)
                    ->delete();
                }
                $traspasos->each->delete();


                // Variable que contiene todos los registros de stock asociados a la bodega.
                $stockBodega = DB::table('stock_bodegas')
                    ->select('bodega_id')
                    ->where('bodega_id', '=', $bodega->id)
                    ->each->delete();

                // Eliminacion del registro de "Bodega" en la base de datos.
                $bodega->delete();

                return response()->json(["bodega"=>$bodega], Response::HTTP_OK);

            } else{
                // Retorno de respuesta HTTP fallida.
                return response()->json(["error"=>"No se encontro la bodega "], Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                // Retorno de respuesta HTTP fallida.
                return response()->json(["error"=>"No se puede eliminar la bodega porque tiene stock asociado"], Response::HTTP_BAD_REQUEST);
            }
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para ver todos los registros de "Bodega".
    public function viewAllBodegas(BodegaRequest $request){
        try {
            // Busqueda de todos los registros de "Bodega" en la Base de datos y asignacion en $bodegas.
            $bodegas = Bodega::all();
            // Retorno de respuesta HTTP exitosa en formato JSON con el contenido encontrado.
            return response()->json(["bodegas"=>$bodegas], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Aqui comienzan las solicitudes HTTP para tabla "stock_bodegas".

    public function viewStock(BodegaRequest $request){
        $id_bodega = $request->id;
        try{
            $stockBodega = DB::table('stock_bodegas')
                ->select('bodega_id', 'bebida_id', 'nombre', 'cantidad')
                ->where('bodega_id', '=', $id_bodega)
                ->get();
            return response()->json(["stock_bodega" => $stockBodega], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para ver stock completo de todas las bodegas
    public function viewAllStock(){
        try {
            // Consultar el stock completo de todas las bodegas desde la tabla "stock_bodegas".
            $stockBodegas = DB::table('stock_bodegas')
                ->select('bodega_id', 'bebida_id', 'nombre', 'cantidad')
                ->get();
            // Retornar la respuesta con el stock completo de todas las bodegas.
            return response()->json(["stock_bodegas" => $stockBodegas], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
