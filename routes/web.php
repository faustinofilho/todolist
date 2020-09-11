<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProjetoController;
use App\Http\Controllers\Admin\TarefaController;


Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::resources([
        'projeto' => ProjetoController::class,
        'tarefa' => TarefaController::class,
    ]);

    Route::get('/tarefa/conclusion/{id}', [TarefaController::class, 'conclusion'])->name('conclusion-tarefa');

});