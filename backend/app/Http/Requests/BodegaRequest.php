<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BodegaRequest extends FormRequest
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
        if ($this->isMethod('post')){
            return [
                'nombre' => 'required|string',
            ];
        }elseif ($this->isMethod('put')){
            return [
                'id' => 'required|integer',
                'nombre' => 'required|string',
            ];
        }elseif ($this->isMethod('delete')){
            return [
                'id' => 'required|integer',
            ];
        }else{
            return [];
        }
    }

    public function messages(){
        return [
            'nombre.required' => 'El nombre es requerido',
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