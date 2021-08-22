<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function Faker\Provider\pt_BR\check_digit;

class HomePageController extends Controller
{
    public function index()
    {
        if ( auth()->check() )
        {
            return ( auth()->user()->isAdmin() ) ? redirect()->route('admin.homepage') : redirect()->route('app.homepage');
        }
        else
        {
            return view('index');
        }
    }

    public function test()
    {
        return view('test');
    }

    public function fallback()
    {
        return redirect()->route('index');
    }
}
