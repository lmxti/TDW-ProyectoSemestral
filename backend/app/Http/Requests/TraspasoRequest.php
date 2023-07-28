<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TraspasoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   // public function authorize(): bool
   // {
   //     return false;
   // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return [
                'bodega_origen_id' => 'required|integer',
                'bodega_destino_id' => 'required|integer',
                'cargamento' => 'required|array',
                'cargamento.*.bebida_id' => 'required|integer',
                'cargamento.*.bebida_nombre' => 'required|string|exists:bebidas,nombre',
                'cargamento.*.cantidad' => 'required|integer',
            ];
        }elseif($this->isMethod('delete')){
            return [
                'id' => 'required|integer',
            ];
        }else{
            return [];
        }
    }

    public function messages(){
        return [
            'bodega_origen_id.required' => 'La bodega de origen es requerida',
            'bodega_origen_id.integer' => 'La bodega de origen debe ser un entero',
            'bodega_destino_id.required' => 'La bodega de destino es requerida',
            'bodega_destino_id.integer' => 'La bodega de destino debe ser un entero',
            'cargamento.required' => 'El cargamento es requerido',
            'cargamento.array' => 'El cargamento debe ser un arreglo',
            'cargamento.*.bebida_id.required' => 'El id de la bebida es requerido',
            'cargamento.*.bebida_id.integer' => 'El id de la bebida debe ser un entero',
            'cargamento.*.bebida_nombre.required' => 'El nombre de la bebida es requerido',
            'cargamento.*.bebida_nombre.string' => 'El nombre de la bebida debe ser un string',
            'cargamento.*.cantidad.required' => 'La cantidad de la bebida es requerida',
            'cargamento.*.cantidad.integer' => 'La cantidad de la bebida debe ser un entero',
            'id.required' => 'El id es requerido',
            'id.integer' => 'El id debe ser un entero',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "message" => "Error de validación",
            "errors" => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}
