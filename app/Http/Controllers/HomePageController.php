<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        if ( auth()->check() )
        {
            return ( auth()->user()->isAdmin() ) ? redirect()->route('admin.homepage') : redirect()->route('user.homepage');
        }
        else
        {
            return view('public.welcome');
        }
    }
}
