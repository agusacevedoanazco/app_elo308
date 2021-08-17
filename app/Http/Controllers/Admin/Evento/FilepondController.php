<?php

namespace App\Http\Controllers\Admin\Evento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilepondController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
    public function index()
    {
        //
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
    public function create()
    {
        //
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        if ($request->hasFile('evento_video'))
        {
            $this->validate($request,['evento_video'=>'required|mimetypes:video/mp4,video/mpeg,video/webm,video/quicktime,video/x-msvideo,video/x-flv']);

            //almacenar video
            $directory = uniqid() . now()->timestamp;
            $filename = $request->file('evento_video')->getClientOriginalName();
            $location = '/'.$directory.'/'.$filename;
            Storage::disk('videos')->put($location, fopen($request->file('evento_video'),'r+'));

            return [
                'filename' => $filename,
                'directory' => $directory,
                'error' => false,
            ];
        }
        else
        {
            return ['error' => true];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function show($id)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function edit($id)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
    public function update(Request $request, $id)
    {
        //
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return boolean
     */
    public function destroy(Request $request)
    {
        return Storage::disk('videos')->deleteDirectory(json_decode($request->getContent())->directory);
    }
}
