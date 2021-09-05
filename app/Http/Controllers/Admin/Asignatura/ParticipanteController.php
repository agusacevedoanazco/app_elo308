<?php

namespace App\Http\Controllers\Admin\Asignatura;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
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
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $asignatura_id)
    {
        try{
            $asignatura = Asignatura::findOrFail($asignatura_id);

            $asignatura->usuarios()->attach($request->usuario);

            return back()->with('okmsg','El usuario ha sido añadido a la lista de participantes');
        }catch (ModelNotFoundException $e){
            return back()->with('errormsg','Hubo un error al agregar al usuario a la lista de participantes');
        }
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
            $estudiantes = $asignatura->usuarios()->where('role',2)->get();
            $profesores = $asignatura->usuarios()->where('role',1)->get();

            $idprofesores = [];
            $idestudiantes = [];

            foreach ($profesores as $profesor) array_push($idprofesores,$profesor->id);
            foreach ($estudiantes as $estudiante) array_push($idestudiantes,$estudiante->id);

            $agregarprofesor = User::where('role',1)->get(['name','last_name','email','id'])->except($idprofesores);
            $agregarestudiante = User::where('role',2)->get(['name','last_name','email','id'])->except($idestudiantes);

            return view('admin.asignaturas.participantes.show')->with([
                'asignatura' => $asignatura,
                'estudiantes' => $estudiantes,
                'profesores' => $profesores,
                'agregarprofesor' => $agregarprofesor,
                'agregarestudiante' => $agregarestudiante,
            ]);
        }catch (ModelNotFoundException $e){
            return redirect()->route('admin.asignaturas.index')->with('errmsg','No se pudo cargar la asignatura seleccionada');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $asignatura_id      Asignatura a remover el enlace
     * @param  int  $user_id            Usuario a desenlazar
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $asignatura_id, int $user_id)
    {
        try{
            $asignatura = Asignatura::findOrFail($asignatura_id);
            $usuario = User::findOrFail($user_id);
            $asignatura->usuarios()->detach($usuario->id);
            return back()->with('okmsg','El usuario ha sido removido de la lista de participantes de la asignatura');
        }catch(ModelNotFoundException $e){
            return back()->with('errormsg','El usuario o asignatura no han sido encontrados, intente nuevamente');
        }
    }
}
