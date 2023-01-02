<?php

namespace App\Http\Requests;

use App\Rules\ValorDDD;
use App\Rules\ValorCNPJ;
use App\Rules\ValorTelefone;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClienteRequest extends FormRequest
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
            return [
                'cnpj' => [new ValorCNPJ],
                'razao_social' => 'min:5',
                'nome_contato' => 'min:5',
                'ddd' => [new ValorDDD],
                'telefone'=> [new ValorTelefone]
            ];
        }

        return [
            'cnpj' => ['required', new ValorCNPJ],
            'razaoSocial' => 'required|min:5',
            'nomeContato' => 'required',
            'ddd' => ['required', new ValorDDD],
            'telefone'=> ['required', new ValorTelefone]
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
            'cnpj.required' => 'É obrigatório a inserção do CNPJ',
            'razaoSocial.required' => 'É obrigatório a inserção do razaoSocial',
            'razaoSocial.min' => 'É necessário no mínimo 5 caracteres para Razão Social',
            'nomeContato.required' => 'É obrigatório a inserção do Nome Contato',
            'ddd.required' => 'É obrigatório a inserção do ddd',
            'telefone.required' => 'É obrigatório a inserção do telefone',
        ];
    }
}
