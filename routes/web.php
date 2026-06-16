<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\FotoController;

// Ruta principal (redirige a la lista de álbumes)
Route::get('/', function () {
    return redirect('/album');
});

// Rutas de Álbumes
Route::get('/album', [AlbumController::class, 'getIndex']);
Route::get('/album/crear', [AlbumController::class, 'getCrear']);
Route::post('/album/crear', [AlbumController::class, 'postCrear']);

// Rutas de Fotos
Route::get('/album/fotos', [FotoController::class, 'index']);
Route::get('/foto/crear', [FotoController::class, 'getCrear']);
Route::post('/foto/crear', [FotoController::class, 'postCrear']);
// Rutas para Eliminar
Route::get('/album/eliminar', [AlbumController::class, 'getEliminar']);
Route::get('/foto/eliminar', [FotoController::class, 'getEliminar']);
// Rutas para Editar Álbumes
Route::get('/album/actualizar', [AlbumController::class, 'getActualizar']);
Route::post('/album/actualizar', [AlbumController::class, 'postActualizar']);

// Rutas para Editar Fotos
Route::get('/foto/actualizar', [FotoController::class, 'getActualizar']);
Route::post('/foto/actualizar', [FotoController::class, 'postActualizar']);