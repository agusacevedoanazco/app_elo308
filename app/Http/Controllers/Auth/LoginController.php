<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password')))
        {
            return back()->with('status','Las credenciales proporcionadas no son válidas. Intente nuevamente');
        } else
        {
            return ( auth()->user()->roleAdmin() ) ? redirect()->route('admin.homepage') : redirect()->route('app.homepage');
        }

    }
}
