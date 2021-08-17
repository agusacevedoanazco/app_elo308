<?php

use Illuminate\Support\Facades\Route;

/** Public Controllers */
use App\Http\Controllers\HomePageController;

/** Auth Controllers */
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

/** Admin Controllers */
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\Departamento\DepartamentoController;
use App\Http\Controllers\Admin\Asignatura\AsignaturaController as AdminAsignaturaController;
use App\Http\Controllers\Admin\Evento\EventoController as AdminEventoController;
use App\Http\Controllers\Admin\Evento\FilepondController as AdminFilepondController;

/** User Controllers */
use App\Http\Controllers\User\HomeController as UserHomeController;

/**
 * Se definen las rutas de la aplicacion.
 * Las rutas se encuentran separadas en publicas, administrativas y de usuario
 * Las direcciones son resueltas mediante el enrutado por middleware de resolucion
 * de rol de usuario y autenticacion de usuario.
 */
/** Public Routes */
Route::get('/', [HomePageController::class, 'index'])->name('index');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::get('/signup', [RegisterController::class, 'index'])->name('signup');
Route::post('/signup', [RegisterController::class, 'store']);

/** Authenticated Routes */
Route::group(['middleware'=>'auth'], function (){
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    /** Admin Routes */
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('homepage');

        /** Departamentos Controllers */
        Route::resource('/departamentos', DepartamentoController::class)->except(['show']);

        /** Asignaturas Controllers */
        Route::resource('/asignaturas', AdminAsignaturaController::class)->except(['show']);

        /** Eventos Controllers */
        Route::resource('/eventos', AdminEventoController::class);

        /** Upload Controllers */
        Route::post('/upload/filepond',[AdminFilepondController::class,'store'])->name('filepond');
        Route::delete('/upload/filepond',[AdminFilepondController::class,'destroy']);

    });

    /** User Routes */
    Route::group(['prefix' => 'app', 'as' => 'app.', 'middleware' => 'user'], function(){
        Route::get('/home', [UserHomeController::class, 'index'])->name('homepage');
    });
});

/** Upload Controller
 *  Se deja afuera de las rutas privadas (user/admin), dado que no se puede pasar por el middleware,
 *  de igual forma, no existen problemas de seguridad, dado que requiere del cross forgery token de sesion
 *  el cual se asocia a una cuenta.
 */
//Route::post('/upload/fpendpoint',[EventoUploadController::class,'store'])->name('fpupload');

/** Fallback route */
Route::fallback( function() { return redirect()->route('login'); } );
