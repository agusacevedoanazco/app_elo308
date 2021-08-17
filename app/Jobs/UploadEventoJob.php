<?php

namespace App\Jobs;

use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UploadEventoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id_evento;
    /**
     * Create a new job instance.
     * @param $id_evento
     * @return void
     */
    public function __construct($id_evento)
    {
        $this->id_evento = $id_evento;
    }

    /**
     * Sube el un video al servicio OpenCast, elimina el archivo local y almacena la información en el evento asociado
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $evento = Evento::findOrFail($this->id_evento);

            //subir video a Opencast
            $request = $this->postEventOpencast($evento);

            if ($request->successful())
            {
                error_log('upload success');
                //insertart identificador de video de opencast en bd
                $evento->evento_oc = $request->object()->identifier;

                //eliminar video y directorio temporal
                Storage::disk('videos')->deleteDirectory($evento->temp_directory);

                //eliminar informacion de video en bd
                $evento->temp_directory = null;
                $evento->temp_filename = null;
                $evento->pendiente = false;

                $evento->save();
            }
            elseif ($request->clientError())
            {
                error_log('client error');
            }
            elseif ($request->serverError())
            {
                error_log('server error');
            }
            else
            {
                error_log('unknown error');
            }
            //error_log('Id evento: '.$evento->id);
            //error_log('Upload event: '. $evento->temp_filename);
            //error_log('In the following directory: ' . $evento->temp_directory);
            //error_log('At timestamp: ' . now()->toDayDateTimeString());
        }
        catch (ModelNotFoundException $exception)
        {
            error_log($exception->getMessage());
            return;
        }
    }

    private function postEventOpencast(Evento $evento)
    {
        $acl = json_encode([
            ['allow'=>true,'action'=>'write','role'=>'ROLE_ADMIN'],
            ['allow'=>true,'action'=>'read','role'=>'ROLE_ADMIN'],
            ['allow'=>true,'action'=>'read','role'=>env('OPENCAST_ROLE_USER')],
            ['allow'=>true,'action'=>'write','role'=>env('OPENCAST_ROLE_USER')],
        ]);

        $metadata = json_encode([
            [
                'flavor' => 'dublincore/episode',
                'fields' => [
                    ['id' => 'title', 'value' => $evento->titulo],
                    ['id' => 'description', 'value' => $evento->descripcion],
                    ['id' => 'isPartOf', 'value' => $evento->asignatura->oc_series_id],
                    ['id' => 'creator', 'value' => [$evento->autor] ],
                ],
            ]
        ]);

        $processing = json_encode([
            'workflow' => 'schedule-and-upload',
            'configuration' => [
                'flagForCutting' => 'false',
                'flagForReview' => 'false',
                'publishToEngage' => 'true',
                'publishToApi' => 'true',
                'straightToPublishing' => 'true',
                'flagQuality360p' => 'true',
                'flagQuality720p' => 'true',
                'flagQuality480p' => 'false',
                'flagQuality1080p' => 'false',
            ]
        ]);

        return Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->attach('acl',$acl)
            ->attach('presenter',Storage::disk('videos')->get($evento->temp_directory . '/' . $evento->temp_filename),$evento->temp_filename)
            ->attach('metadata',$metadata)
            ->attach('processing',$processing)
            ->post(env('OPENCAST_URL').'/api/events/');
    }
}
