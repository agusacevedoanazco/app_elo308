<?php

namespace App\Http\Controllers\Admin\Evento;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateEventoJob;
use App\Jobs\UploadEventoJob;
use App\Models\Asignatura;
use App\Models\Evento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            return back()->with('okmsg','El video ha sido enviado a la cola de procesamiento.');
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
            $evento = Evento::findOrFail($id);
            $asignatura = $evento->asignatura;
            $response = $this->getOpencastEventStatus($evento);

            if($response->successful())
            {
                return view('admin.eventos.show')->with([
                    'evento' => $evento,
                    'asignatura' => $asignatura,
                    'oc_event' => $response->body(),
                ]);
            }
            else
            {
                return back()->with('errmsg','Error al cargar el evento');
            }
        }catch (ModelNotFoundException $exception){
            return redirect()->route('admin.eventos.index');
        }
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
            return redirect()->route('admin.eventos.index');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Evento $evento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evento $evento)
    {
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'evento_video' => 'nullable|json'
        ]);


        //0. Confirmar que se pueden hacer cambios en el evento
        if($evento->pendiente == true) return back()->with('warnmsg','No se puede actualizar el evento, hasta que los cambios pendientes no hayan terminado');
        if($evento->error == true) return back()->with('errmsg','No se puede actualizar el evento, dado que cambios anteriores finalizaron con error');
        $has_file = isset($request->evento_video);
        if ($has_file) if(json_decode($request->evento_video)->error) return back()->with('errmsg','Ocurrió un error al subir el archivo, inténtelo nuevamente');

        //1. Confirmar que hay cambios por hacer
        $title = ($evento->titulo !== $request->titulo) ? $request->titulo : null;
        $description = ($evento->descripcion !== $request->descripcion) ? $request->descripcion : null;

        if (!isset($title) && !isset($description) && !$has_file) return back()->with('warnmsg','No hay cambios por realizar!');

        //bloquea el evento para hacer los cambios hasta que estos hayan sido completados
        $evento->pendiente = true;
        $evento->save();

        //2. Realizar cambios en caso de ser unicamente para la metadata
        if(!$has_file)
        {
            if(isset($title)) $evento->titulo = $title;
            if(isset($description)) $evento->descripcion = $description;
            $evento->save();

            //Actualizar metadata
            $response = $this->putEventMetadata($evento->id);

            //4. Confirmar que los cambios hayan sido realizados correctamente
            if ($response->successful())
            {
                //Se realizó la actualizacion correctamente
                $evento->pendiente = false;
                $evento->save();
                return back()->with('okmsg','Se ha actualizado el evento satisfactoriamente');
            }
            else
            {
                $evento->error = true;
                $evento->save();
                if($response->status() == 400) return back()->with('errmsg','Ocurrió un error al generar la solicitud de actualizacion en el servidor opencast');
                elseif($response->status() == 404) return back()->with('errmsg',"El evento no se encuentra registrado en opencast");
                elseif($response->status() == 412) return back()->with('errmsg',"El evento no se encuentra disponible para su actualización");
                else return back()->with('errmsg',"Error en el servicio Opencast");
            }
            return back()->with('warnmsg','Funcionalidad en mantención');
        }
        //3. Realizar los cambios en caso de requerir la actualizacion del archivo del evento
        else
        {
            //Set the metadata
            if(isset($title)) $evento->titulo = $title;
            if(isset($description)) $evento->descripcion = $description;

            //Set the files
            $evento->temp_directory = json_decode($request->evento_video)->directory;
            $evento->temp_filename = json_decode($request->evento_video)->filename;
            $evento->save();

            //Elimina el evento asociado
            $response = $this->deleteEventOpencast($evento);
            if($response->successful())
            {
                $evento->evento_oc = null;
                UploadEventoJob::dispatch($evento->id);

                return back()->with('okmsg','El video ha sido enviado a la cola de procesamiento.');
            }
            else{
                $evento->error = true;
                $evento->save();
                return back()->with('errormsg','Ocurrió un error al intentar eliminar el evento para su actualización, inténtelo más tarde');
            }

        }
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
            //encontrar el evento a eliminar
            $evento = Evento::findOrFail($id);

            //eliminar de opencast y del registro local
            if (isset($evento->evento_oc)) {
                //eliminar de opencast
                $response = $this->deleteEventOpencast($evento);

                //eliminar del registro local
                if($response->successful()) {
                    $evento->delete();
                    return back()->with('okmsg','Evento eliminado exitosamente');
                }
                else{
                    $evento->error = true;
                    $evento->save();
                    return back()->with('errormsg','Ocurrió un error al eliminar el evento, inténtelo más tarde');
                }
            }
            else {
                $evento->delete();
                return back()->with('okmsg','Evento eliminado satisfactoriamente');
            }
        }catch (ModelNotFoundException $e) {
            return back()->with('errormsg','No se pudo eliminar el evento ya que no existe!');
        }
    }

    /**
     * Update event metadata, doesn't modify the event files
     *
     * @param int $evento_id Evento a modificar
     */
    private function putEventMetadata(int $evento_id)
    {
        try {
            $evento = Evento::findOrFail($evento_id);
        }catch(ModelNotFoundException $e){
            return Http::fake(Http::response("",412))->get('localhost');
        }

        if (!$evento->pendiente || !isset($evento->evento_oc))
        {
            return Http::fake(Http::response([
                "data" => "error",
            ],412))->get('localhost');
        }
        else
        {
            $uri = env('OPENCAST_URL') . '/api/events/' . $evento->evento_oc . '/metadata';

            $metadata = json_encode([
                ['id' => 'title', 'value' => $evento->titulo],
                ['id' => 'description', 'value' => $evento->descripcion],
            ]);

            return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
                ->withHeaders(['Accept' => 'application/json'])
                ->attach('metadata',$metadata)
                ->put($uri . '?type=dublincore/episode');
        }
    }

    private function deleteEventOpencast(Evento $evento)
    {
        $uri = env('OPENCAST_URL') . '/api/events/' . $evento->evento_oc;

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->delete($uri);
    }

    private function getOpencastEventStatus(Evento $evento)
    {
        $uri = env('OPENCAST_URL') . '/api/events/' . $evento->evento_oc;

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get($uri);
    }
}
