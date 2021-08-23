<?php

namespace App\Http\Controllers\Admin\Evento;

use App\Http\Controllers\Controller;
use App\Jobs\UploadEventoJob;
use App\Models\Asignatura;
use App\Models\Evento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = Evento::orderBy('created_at','desc')->paginate(20);

        return view('admin.eventos.index')->with([
            'eventos' => $eventos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asignaturas = Asignatura::all(['id','oc_series_name']);

        return view('admin.eventos.create')->with([
            'asignaturas' => $asignaturas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'titulo' => 'required|max:255',
           'descripcion' => 'required|max:255',
           'asignatura' => 'required|exists:asignaturas,id',
           'evento_video' => 'required|json',
        ]);

        if (json_decode($request->evento_video)->error == true) return back()->with(['errmsg'=>'Error! Ocurrió un error al subir el archivo de video']);
        else{
            //obtener los detalles del archivo a subir
            $tmpdir = json_decode($request->evento_video)->directory;
            $tmpfile = json_decode($request->evento_video)->filename;

            //Encontrar la asignatura asociada en la base de datos
            try{
                $asignatura = Asignatura::findOrFail($request->asignatura);
            }catch (ModelNotFoundException $exception){
                return back()->with(['errmsg'=>'La asignatura especificada no pudo ser encontrada']);
            }

            //crea el evento asociado
            $evento = new Evento;
            $evento->asignatura()->associate($asignatura);
            $evento->titulo = $request->titulo;
            $evento->descripcion = $request->descripcion;
            $evento->temp_directory = $tmpdir;
            $evento->temp_filename = $tmpfile;
            $evento->autor = Auth::user()->name . ' ' . Auth::user()->last_name;
            $evento->pendiente = true;
            $evento->save();

            //Despacha un trabajo para subir el video a Opencast
            UploadEventoJob::dispatch($evento->id);

            //retorna con OK en proceso
            return back()->with('okmsg','El video ha sido enviaddo a la cola de procesamiento.');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        try
        {
            $evento = Evento::findOrFail($id);
            return view('admin.eventos.edit')->with([
                "evento" => $evento,
            ]);
        }catch (ModelNotFoundException $exception)
        {
            return view('admin.eventos.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
