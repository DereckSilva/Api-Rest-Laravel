<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteController extends Controller
{

    private $usuario;

    public function __construct()
    {
        $this->usuario = new Cliente();
    }

    /**
     * @return Cliente
    */
    public function busca(Request $request){

        $usuario = $this->usuario->busca($request->id);

        return Response($usuario, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @return message
     */
    public function criaUsuario(ClienteRequest $request){

        $usuario = $this->usuario->buscaPersonalizada($request->cnpj);

       if(!empty( $usuario[0])) {return Response('Dados já cadastrados', 500)
                                        ->header('Content-Type', 'application/json');}

        $this->usuario->insere($request->all());

        return Response(["message"=>'Dados Inseridos com Sucesso'], 201)->header('Content-Type', 'application/json');

    }

    /**
     * @return message
     */
    public function excluiUsuario(Request $request){

        $usuario = $this->usuario->deleta($request->id);

        return Response($usuario, 200)->header('Content-Type', 'application/json');
    }

    /**
     * @return message
     */
    public function atualiza(ClienteRequest $request){

        $usuario = $this->usuario->atualiza($request->id, $request->all());

        return Response($usuario, 200)->header('Content-Type', 'application/json');
    }
}
