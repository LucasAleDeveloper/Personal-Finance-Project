<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::resource('estudiantes', 'EstudiantesController');
Route::get('movimientos/ultimosMovimientos', 'MovimientosController@ultimosMovimientos');
Route::get('movimientos/ultimosMovimientos/{cantidad}', 'MovimientosController@ultimosMovimientos');
Route::get('movimientos/show/{id}', 'MovimientosController@show');
Route::resource('movimientos', 'MovimientosController');
Route::get('user/saldo/{id}', 'UserController@saldo');
Route::get('user/show/{email}', 'UserController@show');
Route::resource('user','UserController');
Route::resource('tipos_movimientos','TipomovimientoController');
Route::resource('cuotas','PagoCuotasController');
Route::resource('pagos_recurrentes','PagosRecurrentesController');
Route::resource('personas','PersonasController');
Route::get('prestamos_usuario/{user}','PrestamosController@obtenerPrestamosPorUsuario');
Route::get('prestamos_persona/{persona}','PrestamosController@obtenerPrestamosPorPersona');
Route::resource('prestamos','PrestamosController');
Route::resource('categorias','CategoriasController');
Route::resource('images','ImagesController'); 
Route::resource('periodos','PeriodosController');
