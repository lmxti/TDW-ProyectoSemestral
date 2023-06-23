<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador.
use App\Models\Ingreso;
use App\Models\Bodega;
use App\Models\Bebida;

use Illuminate\Http\Request;
// use App\Http\Requests\IngresoRequest;
use Illuminate\Http\Response;
use Exception;

// DB para realizar consultas y operaciones directas en la base de datos.
use Illuminate\Support\Facades\DB;

// Controlador para el modelo de 'Ingreso', que se utiliza para manejar las solicitudes HTTP y ejecutar la logica correspondiente.
class IngresoController extends Controller
{
    /* 
        Metodo para crear un ingreso y la logica que trae:
        1. Obtencion de datos de $request, que trae la informacion de la bodega y el cargamento.
        2. Creacion de un nuevo registro del modelo "Ingreso", al cual se le asigna la informacion de la bodega y el cargamento.
        3. Verificacion de existencia previa en bodega y actualizacion de stock.
        4. Registro de cada bebida del cargamento en la tabla pivote "detalle_ingreso".
    */
    
    public function createIngreso(Request $request){
        try {
            // Obtencion de valores de "bodega_id" y del "cargamento" desde el cuerpo de la solicitud HTTP.
            $bodegaId = $request->bodega_id;
            $cargamento = $request->cargamento;
            // Creacion de un nuevo registro de "Ingreso", al cual se le asigna la informacion de la bodega y el cargamento.
            $ingreso = new Ingreso();
            $ingreso->bodega_id = $bodegaId;
            $ingreso->cargamento = json_encode($cargamento);
            // Guardado del registro en la base de datos.
            $ingreso->save();

            // Iteracion sobre cada elemento del arreglo "cargamento", para obtener el id de la bebida y la cantidad que llego.
            foreach($cargamento as $item){
                // Extraccion y asignacion de los valores "bebida_id" y "cantidad" del elemento actual.
                $bebida_id = $item["bebida_id"];
                $bebida_nombre = $item["bebida_nombre"];
                $cantidad = $item["cantidad"];

                // Verificacion de existencia previa de la bebida($bebida_id) en la bodega($bodegaId).
                $stockBodega = DB::table("stock_bodegas")
                    ->where("bodega_id", $bodegaId)
                    ->where("bebida_id", $bebida_id)
                    ->first();
                
                // En caso de que la bebida ya exista en la bodega, se actualiza la cantidad sumando la cantidad previa mas la nueva.
                if ($stockBodega) {
                    // Acceso a la tabla de "stock_bodegas".
                    DB::table('stock_bodegas')
                        // Condicion de consulta para filtrar el registro por el valor de "bodega_id".
                        ->where("bodega_id", $bodegaId)
                        // Condicion de consulta para filtrar el registro por el valor de "bebida_id".
                        ->where("bebida_id", $bebida_id)
                        // Incremento de la cantidad de bebidas en la bodega.
                        ->increment('cantidad', $cantidad);
                }
                // En caso contrario, se crea un nuevo registro en la tabla "stock_bodegas".
                else{
                    // Acceso a la tabla de "stock_bodegas".
                    DB::table('stock_bodegas')
                        // Insercion de un nuevo registro en la tabla "stock_bodegas" que contiene las columnas y valores a insertar.
                        ->insert([
                            'bodega_id' => $bodegaId,
                            'bebida_id' => $bebida_id,
                            'nombre' => $bebida_nombre,
                            'cantidad' => $cantidad,
                        ]);
                }
                // Registro de item actual en la tabla pivote "detalle_ingreso"
                /*
                    El metodo attach() agrega una entrada en la tabla pivote "detalle_ingreso" que relaciona el ingreso con una bebida especifica,
                    donde se pasa:
                    1.Primer argumento: el "bebida_id" del item actual.
                    2.Segundo argumento: un arreglo asociativo para especificar
                    los datos adicionales como la cantidad del item y las fechas de creacion y actualizacion.
                 */
                $ingreso->bebidas()->attach($item["bebida_id"], [
                "nombre"=>$item["bebida_nombre"],
                "cantidad"=>$item["cantidad"],
                'created_at'=> now(),
                'updated_at'=> now()
                ]);
            }
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["ingreso"=>$ingreso], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
