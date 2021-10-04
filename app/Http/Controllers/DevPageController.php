<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DevPageController extends Controller
{
    public function show(){
        $publicacion = Publicacion::inRandomOrder()->first();

        //api call pool
        //TODO
        //timeseries
        $uri = env('PLAUSIBLE_STATS_API_URL') . 'timeseries';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'period' => '7d',
                'filters' => 'event:path==/app/eventos/'.$publicacion->id,
            ]);
        if ($response->successful()) $timeseries = $response->object()->results;
        //total
        $uri = env('PLAUSIBLE_STATS_API_URL') . 'aggregate';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'metrics' => 'pageviews,visit_duration,visitors',
                'filters' => 'event:path==/app/eventos/'.$publicacion->id,
            ]);
        if ($response->successful()) $totalstats = $response->object()->results;
        //position
        $uri = env('PLAUSIBLE_STATS_API_URL') . 'breakdown';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'period' => '6mo',
                'filters' => 'event:path==/app/eventos/'.$publicacion->id,
                'property' => 'event:props:position'
            ]);
        if ($response->successful()) $position = $response->object()->results;
        //playpause
        $uri = env('PLAUSIBLE_STATS_API_URL') . 'breakdown';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'period' => '6mo',
                'filters' => 'event:path==/app/eventos/'.$publicacion->id,
                'property' => 'event:props:play'
            ]);
        if ($response->successful()) $playpause = $response->object()->results;
        dd($playpause);


        return view('dev')->with([
            'publicacion' => $publicacion,
        ]);
    }
}
