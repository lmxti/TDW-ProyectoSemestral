<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador
use App\Models\Bodega;

use Illuminate\Http\Request;
use App\Http\Requests\BodegaRequest;
use Illuminate\Http\Response;
use Exception;

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
            // Eliminacion del registro de la base de datos.
            $bodega->delete();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bodega"=>$bodega], Response::HTTP_OK);
        } catch (Exception $e) {
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
}
