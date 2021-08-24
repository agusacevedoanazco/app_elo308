<?php

namespace App\Http\Controllers\Admin\Departamento;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamento::paginate(10);

        return view('admin.departamentos.index', [
            'departamentos' => $departamentos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'max:255|required',
            'sigla' => 'max:3|min:3|required|unique:departamentos',
            'carrera' => 'max:255|required',
        ]);

        $departamento = Departamento::create([
            'nombre' => $request->nombre,
            'sigla' => strtoupper($request->sigla),
            'carrera' => $request->carrera,
        ]);

        return back()->with([
            'okmsg' => 'Departamento creado exitosamente'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        try{
            $departamento = Departamento::findOrfail($id);
            return view('admin.departamentos.edit')->with([
                'departamento' => $departamento]
            );
        } catch (ModelNotFoundException $e){
            return redirect()->route('admin.departamentos.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request,[
            'nombre' => 'max:255',
            'carrera' => 'max:255',
        ]);

        try {
            $departamento = Departamento::findOrfail($id);
            $departamento->nombre = $request->nombre;
            $departamento->carrera = $request->carrera;
            $departamento->save();
            return back()->with([
                'okmsg' => 'El departamento ha sido actualizado con éxito!',
            ]);
        } catch (ModelNotFoundException $e){
            return back()->with([
                'errormsg' => 'Error! No se pudo actualizar el departamento, ya que no se encuentra en la base de datos.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try{
            $departamento = Departamento::findOrfail($id);
            $departamento->delete();
            return back()->with([
                'okmsg' => 'El departamento ha sido eliminado satisfactoriamente.',
            ]);
        } catch (ModelNotFoundException $e){
            return back()->with([
                'errormsg' => 'Error! No se pudo eliminar el departamento, ya que no se encuentra enla base de datos.'
            ]);
        }
    }
}
