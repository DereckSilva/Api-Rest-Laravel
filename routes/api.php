<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as RoutingRoute;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('user')->group(function(){

    Route::middleware([ \App\Http\Middleware\ClienteMiddleware::class])->group(function(){

        Route::get('/', [ClienteController::class, 'busca']);

        Route::post('/criaUsuario', [ClienteController::class, 'criaUsuario'])->withoutMiddleware('cliente');

        Route::put('/atualizaUsuario/', [ClienteController::class, 'atualiza']);

        Route::delete('/deletaUsuario/', [ClienteController::class, 'excluiUsuario']);
    });


});

Route::prefix('endereco')->group(function(){

    Route::middleware([\App\Http\Middleware\EnderecoMiddleware::class])->group(function(){

        Route::get('/', [EnderecoController::class, 'buscaEndereco']);

        Route::post('/criaEndereco/', [EnderecoController::class, 'criaEndereco'])
        ->withoutMiddleware('endereco')->middleware('cliente');

        Route::put('/atualizaEnd/', [EnderecoController::class, 'atualizaEndereco']);

        Route::delete('/deletaEnd/', [EnderecoController::class, 'deletaEndereco']);

    });

});
