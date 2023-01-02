<?php

namespace App\Http\Middleware;

use App\Models\Cliente;
use Closure;
use Illuminate\Http\Request;

class ClienteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->id) return Response(["mensagem"=>'Necessário o id do cliente'], 404)
        ->header('Content-Type', 'application/json');

        $cliente = new Cliente();

        $buscaCliente = $cliente->busca($request->id);

        if(!$buscaCliente) return Response(["mensagem"=>'Usuário Não Cadastrado'], 500)
        ->header('Content-Type', 'application/json');

        return $next($request);
    }
}
