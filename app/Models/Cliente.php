<?php

namespace App\Models;

use App\Interface\InterfaceAPIREST;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model implements InterfaceAPIREST
{
    use HasFactory;

    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_contato',
        'ddd_telefone',
        'telefone',
    ];

    public function busca($id){
        $usuario = Cliente::find($id);

        return $usuario;
    }

    public function insere($array){

        Cliente::create([
            'cnpj' => $array['cnpj'],
            'razao_social' => $array['razaoSocial'],
            'nome_contato' => $array['nomeContato'],
            'ddd_telefone' => $array['ddd'],
            'telefone' => $array['telefone'],
        ]);
    }

    public function buscaPersonalizada($cnpj){
        $usuario = Cliente::where([
            ['cnpj', 'like', $cnpj]
        ])->get();

       return $usuario;
    }

    public function deleta($id){

        $usuario = Cliente::findOrFail($id);

        $usuario->delete();

        return ["mensagem"=>'Cliente excluído com sucesso'];
    }

    public function atualiza($id, $array){

        $possiveisValores= ['cnpj', 'razao_social', 'nome_contato', 'ddd_telefone', 'telefone'];

        for($i = 0; $i < count($possiveisValores); $i++){
            $usuario = Cliente::find($id);

            if(array_key_exists($possiveisValores[$i], $array)){
                $usuario->update([
                    $possiveisValores[$i] => $array[$possiveisValores[$i]]
                ]);
            }
        }

        return ["mensagem"=>'Dados Atualizados com sucesso'];

    }

    public function endereco()
    {
        return $this->hasMany(Endereco::class);
    }
}
