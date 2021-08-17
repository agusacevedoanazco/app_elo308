<?php

namespace App\Http\Controllers\Admin\Asignatura;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignaturas = Asignatura::paginate(20);

        return view('admin.asignaturas.index')->with([
            'asignaturas' => $asignaturas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::all(['id','sigla']);

        return view('admin.asignaturas.create')->with([
            'departamentos' => $departamentos,
        ]);
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
            'nombre' => 'max:255|required',
            'anio' => 'digits:4|required',
            'semestre' => 'required|digits:1',
            'paralelo' => 'min:1|max:999|required',
            'codigo' => 'digits:3|required',
            'depto' => 'exists:departamentos,id|required',
        ]);

        try{
            $departamento = Departamento::findOrFail($request->depto);
        } catch (ModelNotFoundException $e) {
            return back()->with('errmsg','No se pudo encontrar el departamento seleccionado en la base de datos');
        }

        $oc_title = $departamento->sigla . $request->codigo . '_' . $request->anio . 'S' . $request->semestre . 'P' . $request->paralelo;
        $oc_subject = $departamento->sigla . $request->codigo;
        $oc_description = $request->nombre;

        if (Asignatura::where('oc_series_name',$oc_title)->exists())
        {
            return back()->with('errmsg','La asignatura enviada ya se encuentra registrada');
        }

        $response = $this->postApiSeries($oc_title,$oc_subject,$oc_description);

        if ($response['status']  == 201)
        {
            $asignatura = New Asignatura();
            $asignatura->oc_series_id = $response['data']->identifier;
            $asignatura->oc_series_name = $oc_title;
            $asignatura->nombre = $request->nombre;
            $asignatura->anio = $request->anio;
            $asignatura->semestre = $request->semestre;
            $asignatura->paralelo = $request->paralelo;
            $asignatura->codigo = $oc_subject;
            $asignatura->departamento()->associate($departamento);
            $asignatura->save();

            return back()->with('okmsg','Asignatura creada con éxito');
        }
        else
        {
            return back()->with('errmsg','No se pudo crear la asignatura en el servicio Opencast');
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
        $asignatura = Asignatura::find($id);

        return view('admin.asignaturas.edit')->with([
            'asignatura' => $asignatura,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Asignatura $asignatura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignatura $asignatura)
    {
        //Validar los valores ingresados
        $this->validate($request,[
            'nombre' => 'max:255|required',
            'anio' => 'digits:4|required',
            'semestre' => 'required|digits:1',
            'paralelo' => 'min:1|max:999|required',
        ]);

        //Asegurar que no hay cambios, para evitar realizar la llamada al servicio
        if ($asignatura->nombre == $request->nombre &&
            $asignatura->anio == $request->anio &&
            $asignatura->semestre == $request->semestre &&
            $asignatura->paralelo == $request->paralelo)
            return back()->with([
                'warnmsg' => 'No se guardaron los cambios'
            ]);
        else{
            $oc_title = $asignatura->codigo . '_' . $request->anio . 'S' . $request->semestre . 'P' . $request->paralelo;
            $oc_description = $request->nombre;
            $oc_series_id = $asignatura->oc_series_id;
            $tmpasignatura = Asignatura::where('oc_series_name',$oc_title)->first();

            if ($tmpasignatura->exists()){
                if ($tmpasignatura->id != $asignatura->id) return back()->with('errmsg','La asignatura ingresada ya se encuentra registrada');
            }

            //actualiza la serie asociada en el servicio Opencast
            $response = $this->updateApiSeries($oc_title,$oc_description,$oc_series_id);

            if ($response->successful())
            {
                //guardar la información en la base de datos
                $asignatura->nombre = $request->nombre;
                $asignatura->anio = $request->anio;
                $asignatura->semestre = $request->semestre;
                $asignatura->paralelo = $request->paralelo;
                return $asignatura->save() ? back()->with('okmsg','Asignatura actualizada satisfactoriamente') : back()->with('errmsg','La asignatura fue modificada en el servicio Opencast, pero no pudo ser actualizada en el sistema de administración');


                //retornar de forma satisfactoria
            }
            else
            {
                 if ($response->failed())
                 {
                     if($response->clientError()) return back()->with('errmsg','Hubo un error al guardar la información en el servicio Opencast');
                     elseif ($response->serverError()) return back()->with('warnmsg','Hubo un error al procesar la información en el servicio Opencast');
                     else return back()->with('errmsg','Ocurrió un error desconocido');
                 }
                 else return back()->with('errmsg','Ocurrió un error desconocido');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asignatura $asignatura)
    {
        $response = $this->deleteApiSeries($asignatura->oc_series_id);

        if ($response->successful())
        {
            return $asignatura->delete() ? back()->with('okmsg','Asignatura eliminada satisfactoriamente') : back()->with('errmsg','La asignatura no pudo ser eliminada del servicio de administración local, pero fue eliminada del servicio Opencast');
        }
        elseif ($response->serverError()) return back()->with('warnmsg','Hubo un error al eliminar la asignatura en el servicio Opencast, series_id'.$asignatura->oc_series_id);
        else return back()->with('errmsg','No se pudo eliminar la asignatura seleccionada');
    }

    private function postApiSeries(string $title, string $subject, string $description)
    {
        $metadata = json_encode([
            [
                'label' => 'Opencast testing Series from Laravel App',
                'flavor' => 'dublincore/series',
                'fields' => [
                    [
                        'id' => 'title',
                        'value' => $title,
                    ],
                    [
                        'id' => 'description',
                        'value' => $description,
                    ],
                    [
                        'id' => 'subject',
                        'value' => $subject,
                    ]
                ]
            ]
        ]);

        $acl = json_encode([
            [
                'allow' => true,
                'action' => 'write',
                'role' => 'ROLE_ADMIN'
            ],
            [
                'allow' => true,
                'action' => 'read',
                'role' => 'ROLE_ADMIN'
            ],
            [
                'allow' => true,
                'action' => 'read',
                'role' => env('OPENCAST_ROLE_USER')
            ],
            [
                'allow' => true,
                'action' => 'write',
                'role' => env('OPENCAST_ROLE_USER')
            ],
        ]);

        $uri = env('OPENCAST_URL') . '/api/series';

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
                ->attach('metadata', $metadata)
                ->attach('acl',$acl)
                ->post($uri);
            return [
                'status' => $response->status(),
                'data' => $response->object(),
            ];
        } catch (RequestException $exception)
        {
            return [
                'status' => $exception->getCode(),
                'data' => $exception->getMessage(),
            ];
        }
    }

    private function updateApiSeries(string $title, string $description, string $series_id)
    {
        //set the uri
        $uri = env('OPENCAST_URL')."/api/series/".$series_id."/metadata?type=dublincore/series";

        $metadata = json_encode([
            [
                'id' => 'title',
                'value' => $title,
            ],
            [
                'id' => 'description',
                'value' => $description,
            ],
        ]);

        return Http::withoutVerifying()
            ->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->attach('metadata', $metadata)
            ->put($uri);
    }

    private function deleteApiSeries(string $series_id)
    {
        $uri = env('OPENCAST_URL')."/api/series/".$series_id;

        return Http::withoutVerifying()
            ->withBasicAuth(env('OPENCAST_USER'),env('OPENCAST_PASSWORD'))
            ->delete($uri);
    }
}
