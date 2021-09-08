<?php

namespace App\Http\Controllers\User\Evento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilepondController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return Storage::disk('videos')->deleteDirectory(json_decode($request->getContent())->directory);
    }
}
