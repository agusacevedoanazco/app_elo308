<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cursos = auth()->user()->cursos()->where('anio',now()->year)->orderByDesc('nombre')->get();
        return view('app.home')->with([
            'cursos' => $cursos,
        ]);
    }
}
