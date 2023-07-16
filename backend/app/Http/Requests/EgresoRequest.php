<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EgresoRequest extends FormRequest
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
                'bodega_id' => 'required|integer',
                'cargamento' => 'required|array',
                'cargamento.*.bebida_id' => 'required|integer',
                'cargamento.*.bebida_nombre' => 'required|alpha',
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
        return[
            'bodega_id.required' => 'La bodega es requerida',
            'bodega_id.integer' => 'La bodega debe ser un entero',
            'cargamento.required' => 'El cargamento es requerido',
            'cargamento.array' => 'El cargamento debe ser un arreglo',
            'cargamento.*.bebida_id.required' => 'El id de la bebida es requerido',
            'cargamento.*.bebida_id.integer' => 'El id de la bebida debe ser un entero',
            'cargamento.*.bebida_nombre.required' => 'El nombre de la bebida es requerido',
            'cargamento.*.bebida_nombre.alpha' => 'El nombre de la bebida debe ser alfabetico',
            'cargamento.*.cantidad.required' => 'La cantidad de la bebida es requerida',
            'cargamento.*.cantidad.integer' => 'La cantidad de la bebida debe ser un entero',
            'id.required' => 'El id es requerido',
            'id.integer' => 'El id debe ser un entero',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "message" => "Error de validacion",
            "errors" => $validator->errors()
        ], Response::HTTP_BAD_REQUEST));
    }
}