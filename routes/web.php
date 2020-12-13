<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::post('/validarCredenciales','ValidarController@validarCredenciales');
Route::post('/inicio','ValidarController@inicio');
Route::post('/preRegistroSocio','ValidarController@preRegistroSocio');


// estas rutas se pueden acceder sin proveer de un token válido.
//Route::post('/login', 'testController@login');
//Route::post('/register', 'PersonasController@register');

// estas rutas requiren de un token válido para poder accederse.
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::post('/logout', 'AuthController@logout');
    //Route::post('/inicio','ValidarController@inicio');

    //ROUTES CONSUMIDAS ADMIN 
        //SOCIOS
        Route::post('/listarSocios','PersonasController@personas');
        Route::post('/confirmarGuardar','PersonasController@personas');
        Route::post('/consultarNumsAsociado','ConfiguracionController@consultarNumsAsociado');    

        //CUOTAS guardarCuota
        Route::post('/gestionCuotas','CuotasController@gestionCuotas');

        //PRESTAMOS 
        Route::post('/ahorroSocio','PrestamosController@ahorroSocio');
        Route::post('/crearCredito','PrestamosController@Credito');

        //PRE-REGISTROS
        Route::post('/preRegitros','PersonasController@preRegitros');

        //ACTIVIDADES
        Route::post('actividades','ConfiguracionController@actividades');
        Route::post('pollaMensual','CuotasController@pollaMensual');



    //ROUTES CONSUMIDAS SOCIOS
        Route::post('/misAhorros', 'PersonasController@misAhorros');
    //ROUTES CONSUMIDAS COMUNES
        Route::post('datosUsuario', 'ValidarController@datosUsuario');
        Route::post('/cambiarContrasenia','PersonasController@cambiarContrasenia'); 

});

