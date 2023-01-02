<?php

namespace App\Models;

use App\Interface\InterfaceAPIREST;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model implements InterfaceAPIREST
{
    use HasFactory;

    private $complemento;

    protected $fillable = [
        'cliente_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'latitude',
        'longitude'
    ];

    public function insere($array){

        $this->complemento = null;

        if(!empty($array['complemento'])) $this->complemento = $array['complemento'];

        Endereco::create([
            'cliente_id' => $array['idCliente'],
            'logradouro' => $array["0"]->address_type,
            'numero' => $array['numero'],
            'complemento' => $this->complemento,
            'bairro' => $array["0"]->district,
            'cidade' => $array["0"]->city,
            'estado' => $array["0"]->state,
            'cep' => $array["0"]->cep,
            'latitude' => $array["0"]->lat,
            'longitude' => $array["0"]->lng
        ]);

        return ["mensagem"=>'Dados inseridos com sucesso'];

    }

    public function busca($id){
        $endereco = Endereco::where('cliente_id','=',$id)->get();

        return $endereco;
    }

    public function atualiza($id, $array)
    {
        $possiveisValores= ['logradouro', 'numero', 'complemento', 'bairro', 'cidade',
                            'estado', 'cep', 'latitude', 'longitude'];

        for($i = 0; $i < count($possiveisValores); $i++){
            $endereco = Endereco::findOrFail($id);

            if($array != null && array_key_exists($possiveisValores[$i], $array)){
                $endereco->update([
                    $possiveisValores[$i] => $array[$possiveisValores[$i]]
                ]);
            }
        }

        return ["mensagem"=>'Dados Atualizados com sucesso'];

    }

    public function buscaId($id){
        $endereco = Endereco::find($id);

       return $endereco;
    }

    public function deleta($id)
    {
        $endereco = Endereco::findOrFail($id);

        $endereco->delete();

        return 'Endereço excluído com sucesso';
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
