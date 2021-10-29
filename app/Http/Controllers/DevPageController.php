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
        $uri = env('PLAUSIBLE_URL') . '/api/v1/stats/' . 'timeseries';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'period' => '30d',
                'filters' => 'event:page==/app/eventos/'.$publicacion->evento->id,
            ]);
        $timeseries = ($response->successful()) ? $response->body() : null;
        //total
        $uri = env('PLAUSIBLE_URL') . '/api/v1/stats/' . 'aggregate';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'metrics' => 'pageviews,visit_duration,visitors',
                'period' => '6mo',
                'filters' => 'event:page==/app/eventos/'.$publicacion->evento->id,
            ]);
        $totalstats =  ($response->successful()) ? $response->body() : null;
        $uri = env('PLAUSIBLE_URL') . '/api/v1/stats/' .  'breakdown';
        $response = Http::withToken(env('PLAUSIBLE_API_KEY'))
            ->acceptJson()
            ->get($uri,[
                'site_id'=> env('PLAUSIBLE_SITE_ID'),
                'period' => '6mo',
                'filters' => 'event:page==/app/eventos/'.$publicacion->evento->id,
                'property' => 'event:props:position'
            ]);
        $bounce = ($response->successful()) ? json_encode($response->object()->results) : null;

        return view('dev')->with([
            'publicacion' => $publicacion,
            'analiticas' => true,
            'timeseries' => $timeseries,
            'totalstats' => $totalstats,
            'bounce' => $bounce,
        ]);
    }
}
