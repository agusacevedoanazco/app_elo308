<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_curso)
    {
        try{
            $curso = Curso::findOrFail($id_curso);
            $estudiantes = $curso->usuarios()->where('role',2)->get();
            $profesores = $curso->usuarios()->where('role',1)->get();

            $idprofesores = [];
            $idestudiantes = [];

            foreach ($profesores as $profesor) array_push($idprofesores,$profesor->id);
            foreach ($estudiantes as $estudiante) array_push($idestudiantes,$estudiante->id);

            $agregarprofesor = User::where('role',1)->get(['name','last_name','email','id'])->except($idprofesores);
            $agregarestudiante = User::where('role',2)->get(['name','last_name','email','id'])->except($idestudiantes);

            return view('admin.cursos.participantes.index')->with([
                'curso' => $curso,
                'estudiantes' => $estudiantes,
                'profesores' => $profesores,
                'agregarprofesor' => $agregarprofesor,
                'agregarestudiante' => $agregarestudiante,
            ]);
        }catch (ModelNotFoundException $e){
            return redirect()->route('admin.cursos.index')->with('errormsg','No se pudo cargar la asignatura seleccionada');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $curso_id)
    {
        try{
            $curso = Curso::findOrFail($curso_id);

            $curso->usuarios()->attach($request->usuario);

            return back()->with('okmsg','El usuario ha sido añadido a la lista de participantes');
        }catch (ModelNotFoundException $e){
            return back()->with('errormsg','Hubo un error al agregar al usuario a la lista de participantes');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $curso_id, int $user_id)
    {
        try{
            $curso = Curso::findOrFail($curso_id);
            $usuario = User::findOrFail($user_id);
            $curso->usuarios()->detach($usuario->id);
            return back()->with('okmsg','El usuario ha sido removido de la lista de participantes del curso');
        }catch(ModelNotFoundException $e){
            return back()->with('errormsg','Hubo un error al buscar el usuario y/o curso, intente nuevamente');
        }
    }
}
