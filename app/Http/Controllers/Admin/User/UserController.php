<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->paginate(20);

        return view('admin.users.index')->with([
           'users' => $users,
        ]);
    }

    public function administradores()
    {
        $users = User::where('role','=',0)
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index')->with([
           'users' => $users,
        ]);
    }

    public function estudiantes()
    {
        $users = User::where('role','=',2)
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }

    public function profesores()
    {
        $users = User::where('role','=',1)
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $rol = '')
    {
        return view('admin.users.create')->with('rol',$rol);
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
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'radiorol' => 'integer|required|min:0|max:2',
            'password' => 'required|confirmed',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->radiorol;
        $user->password = Hash::make($request->password);

        try {
            $user->saveOrFail();
            return back()->with('okmsg','Usuario registrado exitosamente!');
        } catch (ModelNotFoundException $e) {
            return back()->with([
                'errmsg' => 'No se pudo crear el usuario',
                'exception' => $e->getMessage(),
            ]);
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
            $user = User::findOrFail($id);
            return view('admin.users.show')->with([
                'user'=>$user,
                ]);
        }catch (ModelNotFoundException $e){
            return redirect()->route('admin.usuarios.index')->with([
                'errmsg' => 'El usuario al que intenta acceder no existe',
            ]);
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
        try{
            $user = User::findOrFail($id);

            return view('admin.users.edit')->with([
               'user' => $user
            ]);
        }catch (ModelNotFoundException $e)
        {
            return back()->with('errmsg','Usuario no encontrdo!');
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
            'name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'userrole' => 'required|size:3',
        ]);

        try{
            $user = User::findOrFail($id);

            if($request->userrole == 'adm') $user->role = 0;
            elseif ($request->userrole == 'prf') $user->role = 1;
            elseif ($request->userrole == 'std') $user->role = 2;
            else return back()->with('errmsg','Hubo un error al configurar el rol del usuario.');

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->save();

            return back()->with('okmsg','El usuario ha sido actualizado satisfactoriamente!');

        }catch(ModelNotFoundException $e) {
            return back()->with('errmsg','Hubo un error al intentar modificar el usuario.');
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
            $user = User::findOrFail($id);
            $email = $user->email;
            $user->delete();
            return back()->with('okmsg','El usuario con email '.$email.' ha sido eliminado satisfactoriamente');
        }catch (ModelNotFoundException $e){
            return back()->with('errmsg','Error! No se pudo eliminar el usuario seleccionado');
        }
    }

    public function adminUpdatePassword(Request $request, $id)
    {
        $this->validate($request,[
            'password' => 'required|confirmed',
        ]);

        try{
            $user = User::findOrFail($id);
            dd(auth()->user(),$user);
        } catch (ModelNotFoundException $e) {
            return back()->with('errmsg','Hubo un error al encontrar el usuario!');
        }
    }
}
