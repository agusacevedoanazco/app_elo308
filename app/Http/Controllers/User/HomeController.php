<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $asignaturas = auth()->user()->asignaturas()->where('anio',now()->year)->orderByDesc('nombre')->get();
        return view('app.home')->with([
            'asignaturas' => $asignaturas,
        ]);
    }
}
