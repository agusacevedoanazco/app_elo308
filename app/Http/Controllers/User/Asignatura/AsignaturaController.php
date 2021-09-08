<?php

namespace App\Http\Controllers\User\Asignatura;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignaturas = auth()->user()->asignaturas()->paginate();
        return view('app.asignaturas.index')->with([
            'asignaturas' => $asignaturas,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $asignatura = Asignatura::findOrFail($id);
            $profesores = $asignatura->usuarios()->where('role',1)->orderByDesc('last_name')->get();
            $estudiantes = $asignatura->usuarios()->where('role',2)->orderByDesc('last_name')->get();
            $eventos = $asignatura->eventos()->orderByDesc('created_at')->get();
            //dd($asignatura,$eventos,$profesores,$estudiantes);
            return view('app.asignaturas.show')->with([
                'asignatura' => $asignatura,
                'eventos' => $eventos,
                'profesores' => $profesores,
                'estudiantes' => $estudiantes,
            ]);
        } catch (ModelNotFoundException $e){
            return redirect()->route('app.asignaturas.index')->with('errormsg','La asignatura consultada no pudo ser encontrada!');
        }

    }
}
