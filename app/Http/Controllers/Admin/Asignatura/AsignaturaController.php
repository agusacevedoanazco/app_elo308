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
            'paralelo' => 'min:1|max:99|required',
            'codigo' => 'digits:3|required',
            'depto' => 'exists:departamentos,id|required',
        ]);

        try{
            $departamento = Departamento::findOrFail($request->depto);
        } catch (ModelNotFoundException $e) {
            return back()->with('errmsg','No se pudo encontrar el departamento seleccionado en la base de datos');
        }

        $oc_title = $departamento->sigla . $request->codigo . 'P' . $request->paralelo . $request->anio . 'S' . $request->semestre;
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
        //
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
}
