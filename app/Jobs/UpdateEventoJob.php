<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Evento;

class UpdateEventoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id_evento;

    /**
     * Create a new job instance.
     *
     * @param $id_evento
     * @return void
     */
    public function __construct($id_evento)
    {
        $this->$id_evento = $id_evento;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $evento = Evento::findOrFail($this->id_evento);
            //1. checkear que existe el evento y que se encuentra disponible para recibir el video
            //2. actualizar el video
            //3. actualizar modelo
            //TODO
        } catch (ModelNotFoundException $exception) {
            $this->fail($exception);
        }
    }
}
