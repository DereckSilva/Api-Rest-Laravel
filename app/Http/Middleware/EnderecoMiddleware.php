<?php

namespace App\Http\Middleware;

use App\Models\Endereco;
use Closure;
use Illuminate\Http\Request;

class EnderecoMiddleware
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

        if(!$request->idEnd) return Response(["mensagem"=>'Necessário o id do endereço'], 404)
        ->header('Content-Type', 'application/json');

        $endereco = new Endereco();

        $buscaEnd = $endereco->buscaId($request->idEnd);

        if(!$buscaEnd) return Response(["mensagem"=>'Endereço não cadastrado'], 500)
        ->header('Content-Type', 'application/json');

        return $next($request);
    }
}
