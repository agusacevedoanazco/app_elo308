<?php

namespace App\Http\Controllers\Admin\Curso;

use App\Http\Controllers\Controller;
use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cursos = Curso::paginate(20);

        return view('admin.cursos.index')->with([
            'cursos' => $cursos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = Departamento::all('id','sigla');

        return view('admin.cursos.create')->with([
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
            'semestre' => 'digits:1|required',
            'paralelo' => 'min:1|max:999|required',
            'codigo' => 'digits:3|required',
            'departamento' => 'exists:departamentos,id|required',
        ]);

        try{
            $departamento = Departamento::findOrFail($request->departamento);
        }catch (ModelNotFoundException $e){
            return back()->with('errormsg','No se pudo encontrar el departamento seleccionado');
        }

        $title = $departamento->sigla . $request->codigo . '_' . $request->anio . 'S' . $request->semestre . 'P' . $request->paralelo;
        $subject = $departamento->sigla .' '. $request->codigo;
        $description = $request->nombre;

        if (Curso::where('oc_series_name',$title)->exists()){
            return back()->with('warnmsg','El curso ya se encuentra registrado.');
        }

        $response = $this->postSeries($title,$subject,$description);

        if($response->successful()){
            $curso = New Curso();
            $curso->oc_series_id = $response->object()->identifier;
            $curso->oc_series_name = $title;
            $curso->nombre = $request->nombre;
            $curso->anio = $request->anio;
            $curso->semestre = $request->semestre;
            $curso->paralelo = $request->paralelo;
            $curso->codigo = $departamento->sigla . $request->codigo;
            $curso->departamento()->associate($departamento);
            $curso->save();

            return back()->with('okmsg','El curso fue creado con éxito.');
        }
        else{
            if($request->clientError()) {
                return back()->with('errormsg','Hubo un error publicar la asignatura en el servicio Opencast.');
            }
            else{
                return back()->with('errormsg','Error al comunicarse con el servidor Opencast.');
            }
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
        try {
            $curso = Curso::findOrFail($id);
            return view('admin.cursos.show')->with([
                'curso' => $curso,
            ]);
        }catch (ModelNotFoundException $e) {
            return redirect()->route('admin.cursos.index')->with('warnmsg','El curso que intenta consultar no existe!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $curso = Curso::findOrFail($id);
            return view('admin.cursos.edit')->with([
                'curso' => $curso,
            ]);
        } catch (ModelNotFoundException $e){
            return redirect()->route('admin.cursos.index')->with('warnmsg','El curso que intenta editar no existe!');
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
        $this->validate($request,[
            'nombre' => 'max:255|required',
            'anio' => 'digits:4|required',
            'semestre' => 'required|digits:1',
            'paralelo' => 'min:1|max:999|required',
        ]);

        try{
            $curso = Curso::findOrFail($id);

            $title = $curso->codigo . '_' . $request->anio . 'S' . $request->semestre . 'P' . $request->paralelo;
            $description = $request->nombre;
            $oc_id= $curso->oc_series_id;

            if(Curso::where('oc_series_name',$title)->exists()) return back()->with('errormsg','El curso ya se encuentra registrado!');

            $response = $this->updateSeries($title,$description,$oc_id);

            if ($response->successful())
            {
                //guardar la información en la base de datos
                $curso->nombre = $request->nombre;
                $curso->anio = $request->anio;
                $curso->semestre = $request->semestre;
                $curso->paralelo = $request->paralelo;
                $curso->oc_series_name = $title;
                $curso->save();
                return back()->with('okmsg','Asignatura actualizada satisfactoriamente');
            }
            else
            {
                if($response->clientError()) return back()->with('errormsg','El curso (serie) no existe en el servidor Opencast');
                elseif ($response->serverError()) return back()->with('warnmsg','Hubo un error al contactar el servidor Opencast');
                else return back()->with('errormsg','Ocurrió un error desconocido');
            }

        }catch (ModelNotFoundException $e){
            return redirect()->route('admin.cursos.index')->with('warnmsg','El curso que intenta editar no existe!');
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
        try {
            $curso = Curso::findOrFail($id);
            $response = $this->deleteSeries($curso->oc_series_id);

            if($response->successful()){
                $curso->delete();
                return back()->with('okmsg','El curso ha sido eliminado satisfactoriamente');
            }else{
                if($response->clientError()) return back()->with('errormsg','El curso (serie) no existe en el servidor Opencast');
                elseif ($response->serverError()) return back()->with('warnmsg','Hubo un error al contactar el servidor Opencast');
                else return back()->with('errormsg','Ocurrió un error desconocido');
            }
        }catch (ModelNotFoundException $e){
            return redirect()->route('admin.cursos.index')->with('errormsg','El curso no pudo ser eliminado porque no existe');
        }
    }

    private function postSeries(string $title, string $subject, string $description){
        $metadata = json_encode([
           [
               'flavor' => 'dublincore/series',
               'fields' => [
                   ['id'=>'title','value'=>$title],
                   ['id'=>'description','value'=>$description],
                   ['id'=>'subject','value'=>$subject]
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
            [
                'allow' => true,
                'action' => 'read',
                'role' => 'ROLE_ANONYMOUS',
            ],
        ]);

        return Http::withoutVerifying()
            ->withHeaders(['Accept' => 'application/json'])
            ->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->attach('metadata', $metadata)
            ->attach('acl',$acl)
            ->post(env('OPENCAST_URL').'/api/series');
    }

    private function updateSeries(string $title, string $description, string $series_id)
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
            ->withHeaders(['Accept' => 'application/json'])
            ->attach('metadata', $metadata)
            ->put($uri);
    }

    private function deleteSeries(string $series_id)
    {
        $uri = env('OPENCAST_URL')."/api/series/".$series_id;

        return Http::withoutVerifying()
            ->withBasicAuth(env('OPENCAST_USER'),env('OPENCAST_PASSWORD'))
            ->delete($uri);
    }
}
