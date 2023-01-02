<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnderecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        if($this->method('PUT')){
            return [];
        }

        return [
            "logradouro" => 'required' ,
            "numero" => 'required',
            "bairro" => 'required' ,
            "cidade" => 'required' ,
            "estado" => 'required' ,
            "cep" => 'required',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro na validação',
            'data' => $validator->errors()
        ]));
    }

    public function messages(){
        return [
            'logradouro.required' => 'É obrigatório a inserção do logradouro',
            'numero.required' => 'É obrigatório a inserção do numero',
            'bairro.required' => 'É obrigatório a inserção do bairro',
            'cidade.required' => 'É obrigatório a inserção da cidade',
            'estado.required' => 'É obrigatório a inserção do estado',
            'cep.required' => 'É obrigatório a inserção do cep',
        ];
    }
}
