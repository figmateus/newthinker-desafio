<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UfController, MunicipioController, BairroController,PessoaController};

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('uf', [UfController::class, 'index']);
Route::post('uf',[UfController::class, 'store']);
Route::put('uf/{codigoUF}', [UfController::class, 'update']);
Route::get('municipio',[MunicipioController::class, 'index']);
Route::post('municipio',[MunicipioController::class, 'store']);
Route::put('municipio/{id}',[MunicipioController::class, 'update']);
Route::get('bairro',[BairroController::class, 'index']);
Route::post('bairro',[BairroController::class, 'store']);
Route::put('bairro/{id}',[BairroController::class, 'update']);
Route::get('pessoa',[PessoaController::class, 'index']);
Route::post('pessoa',[PessoaController::class, 'store']);
