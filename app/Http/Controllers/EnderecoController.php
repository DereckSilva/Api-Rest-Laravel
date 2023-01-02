<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Models\Cliente;
use App\Models\Endereco;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnderecoController extends Controller
{
    private $endereco;
    private $cliente;

    public function __construct()
    {
        $this->endereco = new Endereco();
        $this->cliente = new Cliente();
    }

    /**
     *
     * @return
     *
     */

    private static function cep($cep){

        try{
            $dadosEndereco = file_get_contents("https://cep.awesomeapi.com.br/json/$cep");

            return $dadosEndereco;

        }catch(Exception $e){
            return Response(["mensagem"=>'Cep Inválido'], 404)->header('Content-Type', 'application/json');
        }

    }

    /**
     *
     * @return array<string>
     *
     */

    public function buscaEndereco(Request $request){

        $endereco = $this->endereco->busca($request->idEnd);

        return $endereco;
    }

    /**
     *
     * @return string
     *
     */
    public function criaEndereco(EnderecoRequest $request){

        try{
            $newArray = array();

            $dadosEndereco = self::cep($request->cep);

            if(is_object($dadosEndereco) && $dadosEndereco->getStatusCode() === 404) {
                return Response(["mensagem"=>'Cep Inválido'], 404)->header('Content-Type', 'application/json');
            }

            if(!empty($request->complemento)) $newArray['complemento'] = $request->complemento;

            array_push($newArray, json_decode($dadosEndereco));
            $newArray['numero'] = $request->numero;
            $newArray['idCliente'] = $request->id;

            $cad = $this->endereco->insere($newArray);

            return $cad;

        }catch(Exception $e){
            return Response($e->getMessage(), 404)->header('Content-Type', 'application/json');
        }

        return $dadosEndereco;

    }

    /**
     *
     * @return string
     *
     */

    public function atualizaEndereco(EnderecoRequest $request){

        try{

            if($request->cep) {
                $dados_endereco = self::cep($request->cep);

                if(is_object($dados_endereco) && $dados_endereco->getStatusCode() === 404) {
                    return Response(["messagem"=>'Cep Inválido'], 404)->header('Content-Type', 'application/json');
                }
            }

            $endereco = $this->endereco->atualiza($request->idEnd, $request->all());

            return $endereco;
        }catch(Exception $e){
            return Response($e->getMessage())->header('Content-Type', 'application/json');
        }
    }

    /**
     *
     * @return string
     *
     */

    public function deletaEndereco(Request $request){

        $endereco = $this->endereco->deleta($request->idEnd);

        return $endereco;
    }
}
