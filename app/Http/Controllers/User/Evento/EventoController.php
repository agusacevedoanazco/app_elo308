<?php

namespace App\Http\Controllers\User\Evento;

use App\Http\Controllers\Controller;
use App\Jobs\UploadEventoJob;
use App\Models\Asignatura;
use App\Models\Evento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $id = null)
    {
        if (isset($id)){
            try{
                $asignatura = Asignatura::findOrFail($id);
                return view('app.eventos.create')->with([
                    'asignatura' => $asignatura,
                ]);
            }catch(ModelNotFoundException $e){
                return redirect()->route('app.asignaturas.index')->with('warnmsg','No tiene los permisos necesarios para ver y/o modificar la asignatura');
            }
        }
        else{
            $asignaturas = auth()->user()->asignaturas()->orderByDesc('created_at')->get();
            return view('app.eventos.create')->with([
                'asignaturas' => $asignaturas,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'asignatura' => 'required|exists:asignaturas,id',
            'evento_video' => 'required|json',
        ]);

        if(json_decode($request->evento_video)->error == true) return back()->with('errormsg','Ocurrió un error al subir el archivo de video');
        else{
            $tmpdir = json_decode($request->evento_video)->directory;
            $tmpfile = json_decode($request->evento_video)->filename;

            try{
                $asignatura = Asignatura::findOrFail($request->asignatura);
            }catch (ModelNotFoundException $e){
                return back()->with('errormsg','La asignatura seleccionada no pudo ser obtenida');
            }

            //crea el evento asociado
            $evento = new Evento;
            $evento->asignatura()->associate($asignatura);
            $evento->titulo = $request->titulo;
            $evento->descripcion = $request->descripcion;
            $evento->temp_directory = $tmpdir;
            $evento->temp_filename = $tmpfile;
            $evento->autor = auth()->user()->name . ' ' . auth()->user()->last_name;
            $evento->pendiente = true;
            $evento->save();

            //Despacha un trabajo para subir el video a Opencast
            UploadEventoJob::dispatch($evento->id);

            //retorna con OK en proceso
            return back()->with('okmsg','El video fue enviado correctamente a la cola de procesamiento, para su posterior publicación');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try{
            $evento = Evento::findOrFail($id);
            if (isset($evento->evento_oc)) {
                $response = $this->deleteEventOpencast($evento);

                if($response->successful()){
                    $evento->delete();
                    return back()->with('okmsg','El evento ha sido eliminado exitosamente');
                }
                else{
                    if ($response->serverError()){
                        return back()->with('warnmsg','Hubo un error al contactar con el servicio Opencast, intente más tarde');
                    }
                    else{
                        $evento->error = true;
                        $evento->save();
                        return back()->with('errormsg','Hubo un error al intentar eliminar el evento!');
                    }
                }
            }
            else{
                $evento->delete();
                return back()->with('okmsg','Evento eliminado satisfactoriamente');
            }
        }catch (ModelNotFoundException $e) {
            return back()->with('errormsg','No se pudo eliminar el evento ya que no existe!');
        }
    }

    private function deleteEventOpencast(Evento $evento)
    {
        $uri = env('OPENCAST_URL') . '/api/events/' . $evento->evento_oc;

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->delete($uri);
    }
}
