<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;

class DevPageController extends Controller
{
    public function show(){
        return view('dev')->with([
            'publicacion' => Publicacion::inRandomOrder()->first(),
        ]);
    }
}
