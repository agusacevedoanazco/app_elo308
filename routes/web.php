<?php

use Illuminate\Support\Facades\Route;

/** Public Controllers */
use App\Http\Controllers\HomePageController;

/** Auth Controllers */
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

/** Dev Controllers */
/** No deben estar en servidor en produccion */
use App\Http\Controllers\DevPageController;

/** Admin Controllers */
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\Departamento\DepartamentoController;
use App\Http\Controllers\Admin\Curso\CursoController as AdminCursoController;
use App\Http\Controllers\Admin\Curso\ParticipanteController as AdminCursoParticipanteController;
use App\Http\Controllers\Admin\Evento\EventoController as AdminEventoController;
use App\Http\Controllers\Admin\Evento\FilepondController as AdminFilepondController;
use App\Http\Controllers\Admin\User\UserController as AdminUserController;

/** User Controllers */
use App\Http\Controllers\User\HomeController as AppHomeController;
use App\Http\Controllers\User\Curso\CursoController as AppCursoController;
use App\Http\Controllers\User\Evento\EventoController as AppEventoController;
use App\Http\Controllers\User\PerfilController;

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

Route::group(['prefix'=>'dev','as'=>'dev.'], function(){
    Route::get('/video',[DevPageController::class,'show'])->name('video');
});

/** Authenticated Routes */
Route::group(['middleware'=>'auth'], function (){
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

    /** Admin Routes */
    Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('homepage');

        /** Departamentos Controllers */
        Route::resource('/departamentos', DepartamentoController::class);

        /** Cursos Controllers */
        Route::resource('/cursos',AdminCursoController::class);

        /** Participantes Controllers */
        Route::get('/cursos/{id}/participantes',[AdminCursoParticipanteController::class,'index'])->name('cursos.participantes.index');
        Route::post('/cursos/{curso_id}/participantes',[AdminCursoParticipanteController::class,'store'])->name('cursos.participantes.store');
        Route::delete('/cursos/{curso_id}/participantes/{user_id}',[AdminCursoParticipanteController::class,'destroy'])->name('cursos.participantes.destroy');

        /** Eventos Controllers */
        Route::resource('/eventos', AdminEventoController::class);
        Route::get('/eventos/{id}/analiticas',[AdminEventoController::class,'analiticas'])->name('eventos.analiticas');

        /** Upload Controllers */
        Route::post('/upload/filepond',[AdminFilepondController::class,'store'])->name('filepond');
        Route::delete('/upload/filepond',[AdminFilepondController::class,'destroy']);

        /** Users Controllers */
        Route::get('/usuarios/administradores',[AdminUserController::class,'administradores'])->name('usuarios.administradores');
        Route::get('/usuarios/profesores',[AdminUserController::class,'profesores'])->name('usuarios.profesores');
        Route::get('/usuarios/estudiantes',[AdminUserController::class,'estudiantes'])->name('usuarios.estudiantes');
        Route::get('/usuarios/create/{rol?}',[AdminUserController::class,'create'])->name('usuarios.create');
        Route::put('/usuarios/{id}/adminUpdatePassword',[AdminUserController::class,'adminUpdatePassword'])->name('usuarios.admputpwd');
        Route::resource('/usuarios',AdminUserController::class)->except(['create']);

    });

    /** User Routes */
    Route::group(['prefix' => 'app', 'as' => 'app.', 'middleware' => 'user'], function(){
        Route::get('/home', [AppHomeController::class, 'index'])->name('homepage');

        Route::resource('/cursos',AppCursoController::class)->only(['show','index']);

        Route::get('/eventos/create/{id?}',[AppEventoController::class,'create'])->name('eventos.create');
        Route::resource('/eventos',AppEventoController::class)->except(['index','create']);
        Route::get('/eventos/{id}/analiticas',[AppEventoController::class,'analiticas'])->name('eventos.analiticas');

        Route::post('/upload/filepond',[AdminFilepondController::class,'store'])->name('filepond');
        Route::delete('/upload/filepond',[AdminFilepondController::class,'destroy']);

        Route::get('/myprofile',[PerfilController::class, 'index'])->name('perfil.index');
        Route::put('/myprofile/update/{id}/password',[PerfilController::class,'updatePassword'])->name('perfil.update.password');
    });
});

/** Fallback route */
Route::fallback( function() { return redirect()->route('login'); } );
