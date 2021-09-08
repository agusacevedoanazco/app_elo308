<?php

namespace App\Console\Commands\Opencast\Schedule;

use App\Models\Evento;
use App\Models\Publicacion;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

class updateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opencast:updateEE';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de publicacion de los eventos pendientes por publicar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info(now()->toDateTimeString() . ' | INFO | Actualizando el estado de publicación de los eventos pendientes.');
        try {
            $eventos = Evento::where('pendiente', false)
                ->whereDoesntHave('publicacion')
                ->where('error', false)
                ->where('publicado', false)
                ->get();

            if($eventos->count() == 0){
                $this->info(now()->toDateTimeString() . ' | INFO | No hay eventos pendientes');
                return 0;
            }

            foreach ($eventos as $evento) {
                $response = $this->getEventStatus($evento->evento_oc);
                if ($response->successful()){
                    if ($response->object()->status == "EVENTS.EVENTS.STATUS.PROCESSED"){
                        $response = $this->getPublications($evento->evento_oc);
                        if($response->successful()) {
                            $media = $response->object()[1]->media;
                            $ocid = $response->object()[1]->id;

                            $publicacion = new Publicacion();
                            $publicacion->oc_publication_id = $ocid;

                            foreach ($media as $video){
                                if($video->tags[0] == '360p-quality'){
                                    $publicacion['360p-quality_url'] = $video->url;
                                    $publicacion->mediatype = $video->mediatype;
                                }
                                elseif($video->tags[0] == '480p-quality') $publicacion['480p-quality_url'] = $video->url;
                                elseif($video->tags[0] == '720p-quality') $publicacion['720p-quality_url'] = $video->url;
                                elseif($video->tags[0] == '1080p-quality') $publicacion['1080p-quality_url'] = $video->url;
                                elseif($video->tags[0] == '2160p-quality') $publicacion['2160p-quality_url'] = $video->url;
                            }

                            $publicacion->evento()->associate($evento->id);
                            $publicacion->save();

                            $evento->publicado = true;
                            $evento->save();
                        }
                    }
                    elseif ($response->object()->status == "EVENTS.EVENTS.STATUS.PROCESSING"){
                        $this->info(now()->toDateTimeString() . ' | INFO | '.'El evento id = ' . $evento->id . '. De oc_uid = ' . $evento->evento_oc . ' aún se encuentra en proceso de publicación...');
                    }
                }
                else{
                    if($response->clientError()){
                        $evento->error = true;
                        $this->info(now()->toDateTimeString() . ' | ERROR | '.'El evento id = ' . $evento->id . '. De oc_uid = ' . $evento->evento_oc . ' no existe en el servicio Opencast!');
                        $this->info($response->getState());
                    }
                    else{
                        $this->info(now()->toDateTimeString() . ' | ERROR | El proceso de actualización de estado de publicación de eventos ha finalizado con errores, dado que no se pudo contactar el servicio Opencast.');
                        return -1;
                    }
                }
            }
            $this->info(now()->toDateTimeString() . ' | INFO | El proceso de actualización de estado de publicación de eventos ha finalizado exitosamente.');
            return 0;
        } catch (ModelNotFoundException $e) {
            error_log($e->getMessage());
            $this->info('Hubo un error al intentar obtener los eventos pendientes de publicación.');
            return 1;
        }
    }

    private function getEventStatus(string $opencast_event_uid)
    {
        $uri = env('OPENCAST_URL') . '/api/events/' . $opencast_event_uid;

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get($uri);
    }

    private function getPublications(string $opencast_event_uid)
    {
        $uri = env('OPENCAST_URL') . '/api/events/' . $opencast_event_uid . '/publications';

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get($uri);
    }
}
