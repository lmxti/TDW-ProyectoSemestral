<?php

namespace App\Http\Controllers;

// Modelos utilizados por el controlador.
use App\Models\Bebida;

use Illuminate\Http\Request;
use App\Http\Requests\BebidaRequest;
use Illuminate\Http\Response;
use Exception;

// Controlador para el modelo 'Bebida', que se utiliza para manejar las solicitudes HTTP y ejecutar la logica correspondiente.
class BebidaController extends Controller
{
    // Metodo para crear un registro de "Bebida".
    public function createBebida(BebidaRequest $request){
        try {
            // Creacion de nuevo registro de "Bebida". 
            $bebida = new Bebida();
            // Asignacion de valores a los atributos del modelo.
            $bebida->nombre = $request->nombre;
            $bebida->sabor = $request->sabor;
            $bebida->tamano = $request->tamano;
            // Guardado del registro en la base de datos.
            $bebida->save();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para ver un registro de "Bebida" utilizando el id de la bebida.
    public function viewBebida(BebidaRequest $request){
        try {
            // Busqueda del registro de "Bebida" en la Base de datos utilizando el valor del campo "id" y asignacion en $bebida.
            $bebida = Bebida::find($request->id);
            // Retorno de respuesta HTTP exitosa en formato JSON con el contenido encontrado.
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para actualizar valores de un registro de "Bebida" utilizando el id de la bebida.
    public function updateBebida(BebidaRequest $request){
        try {
            // Busqueda del registro de "Bebida" en la Base de datos utilizando el valor del campo "id" y asignacion en $bebida.
            $bebida = Bebida::find($request->id);
            // Asignacion de valores a actualizar del registro de $bebida.
            $bebida->nombre = $request->nombre;
            $bebida->sabor = $request->sabor;
            $bebida->tamano = $request->tamano;
            // Guardado del registro en la base de datos.
            $bebida->save();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para eliminar un registro de "Bebida" utilizando el id de la bebida.
    public function deleteBebida(BebidaRequest $request){
        try {
            // Busqueda del registro de "Bebida" en la Base de datos utilizando el valor del campo "id" y asignacion en $bebida.
            $bebida = Bebida::find($request->id);
            // Eliminacion del registro de la base de datos.
            $bebida->delete();
            // Retorno de respuesta HTTP exitosa.
            return response()->json(["bebida"=>$bebida], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    // Metodo para ver todos los registros de "Bebida" existentes en la base de datos.
    public function viewAllBebidas(BebidaRequest $request){
        try {
            // Busqueda de todos los registros de "Bebida" en la Base de datos y asignacion en $bebidas.
            $bebidas = Bebida::all();
            // Retorno de respuesta HTTP exitosa, en formato JSON con el contenido encontrado.
            return response()->json(["bebidas"=>$bebidas], Response::HTTP_OK);
        } catch (Exception $e) {
            // Retorno de respuesta HTTP fallida.
            return response()->json(["error"=>$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
