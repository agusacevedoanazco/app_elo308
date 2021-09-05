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
use App\Http\Controllers\Admin\User\UserController as AdminUserController;
use App\Http\Controllers\Admin\Asignatura\ParticipanteController as AdminAsignaturaParticipanteController;

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
        Route::resource('/departamentos', DepartamentoController::class);

        /** Asignaturas Controllers */
        Route::resource('/asignaturas', AdminAsignaturaController::class);
        Route::get('/asignaturas/{id}/participantes',[AdminAsignaturaController::class,'showMembers'])->name('asignaturas.showmembers');

        /** Asignaturas Participantes Controllers */
        Route::get('/asignaturas/{id}/participantes',[AdminAsignaturaParticipanteController::class,'show'])->name('asignaturas.participantes.show');
        Route::delete('/asignaturas/{asignatura_id}/participantes/{user_id}',[AdminAsignaturaParticipanteController::class,'destroy'])->name('asignaturas.participantes.destroy');
        Route::post('/asignaturas/{asignatura_id}/participantes',[AdminAsignaturaParticipanteController::class,'store'])->name('asignaturas.participantes.store');

        /** Eventos Controllers */
        Route::resource('/eventos', AdminEventoController::class);

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
        Route::get('/home', [UserHomeController::class, 'index'])->name('homepage');
    });
});

/** Fallback route */
Route::fallback( function() { return redirect()->route('login'); } );
