<?php

namespace App\Http\Controllers\User\Curso;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = auth()->user()->cursos()->paginate();
        return view('app.cursos.index')->with('cursos',$cursos);
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
            $curso = Curso::findOrFail($id);

            $this->authorize('participa',$curso);

            $profesores = $curso->usuarios()->where('role',1)->orderByDesc('last_name')->get();
            $estudiantes = $curso->usuarios()->where('role',2)->orderByDesc('last_name')->get();
            $eventos = $curso->eventos()->orderByDesc('created_at')->get();
            //dd($curso,$eventos,$profesores,$estudiantes);
            return view('app.cursos.show')->with([
                'curso' => $curso,
                'eventos' => $eventos,
                'profesores' => $profesores,
                'estudiantes' => $estudiantes,
            ]);
        } catch (ModelNotFoundException $e){
            return redirect()->route('app.cursos.index')->with('errormsg','La curso consultada no pudo ser encontrada!');
        }
    }
}
