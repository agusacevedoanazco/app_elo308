<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        //dd($user);
        return view('app.myprofile')->with([
            'user' => $user,
        ]);
    }

    public function updatePassword(Request $request, int $id)
    {
        if (auth()->user()->id != $id){
            return redirect()->route('app.perfil.index')->with('errmsg','No se puede cambiar la contraseña de otro usuario!');
        }

        $this->validate($request,[
            'password' => 'required|confirmed',
        ]);

        try{
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('app.perfil.index')->with('okmsg','La constraseña ha sido cambiada exitosamente');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('app.perfil.index')->with('errmsg','Hubo un error al intentar actualizar la contraseña!');
        }
    }

}
