<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProyectoController; //Importacion del controlador

Route::get('/', function () {
    return view('welcome');
});

Route::post('/proyecto',[ProyectoController::class,'store']);

Route::get('/proyecto',[ProyectoController::class,'index'])->name('proyecto.index');

Route::put('/proyecto/{proyecto}',[ProyectoController::class,'update'])->name('proyecto.update');

Route::get('/proyecto/{proyecto}',[ProyectoController::class,'show'])->name('proyecto.show');

Route::delete('/proyecto/{proyecto}',[ProyectoController::class,'destroy']);






