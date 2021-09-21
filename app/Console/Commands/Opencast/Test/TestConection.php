<?php

namespace App\Console\Commands\Opencast\Test;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestConection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opencast:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprueba el estado de conexion al servidor Opencast con los datos ingresados en el archivo .env';

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
        $uri = env('OPENCAST_URL') . '/api/events';

        $response = Http::withoutVerifying()->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
            ->withHeaders(['Accept' => 'application/json'])
            ->get($uri);

        if ($response->successful()){
            $this->info(now()->toDateTimeString() . ' | INFO | El servidor Opencast se encuentra disponible para su comunicacion.');
            return 0;
        }else{
            if ($response->clientError()){
                $this->info(now()->toDateTimeString() . ' | INFO | El servidor ha devuelto una respuesta con codigo ' . $response->status());
                $this->info(now()->toDateTimeString() . ' | INFO | El servidor Opencast se encuentra disponible, pero el requerimiento realizado es erroneo.');
                return 1;
            }
            elseif ($response->serverError()){
                $this->info(now()->toDateTimeString() . ' | ERROR | No se pudo establecer conexion con el servidor Opencast.');
                return -1;
            }
            else{
                $this->info(now()->toDateTimeString() . ' | ERROR | Ocurrio un error que no se puede identificar al intentar establecer la conexion con el servidor Opencast.');
                return -1;
            }
        }
    }
}
