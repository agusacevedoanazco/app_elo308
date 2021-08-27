<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $total_eventos = Evento::count();
        $total_asignaturas = Asignatura::count();
        $total_departamentos = Departamento::count();
        $total_usuarios = User::count();
        return view('admin.home')->with([
            'total_eventos' => $total_eventos,
            'total_asignaturas' => $total_asignaturas,
            'total_departamentos' => $total_departamentos,
            'total_usuarios' => $total_usuarios,
        ]);
    }
}
