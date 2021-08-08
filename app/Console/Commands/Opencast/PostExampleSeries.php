<?php

namespace App\Console\Commands\Opencast;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;

class PostExampleSeries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opencast:postExSeries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea una serie de prueba en el servicio Opencast';

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
        $metadata = json_encode([
            [
                'label' => 'Opencast testing Series from Laravel App',
                'flavor' => 'dublincore/series',
                'fields' => [
                    [
                        'id' => 'title',
                        'value' => 'Series title',
                    ],
                    [
                        'id' => 'description',
                        'value' => 'Series Description',
                    ],
                    [
                        'id' => 'subject',
                        'value' => 'Series Subject',
                    ]
                ]
            ]
        ]);

        $acl = json_encode([
            [
                'allow' => true,
                'action' => 'write',
                'role' => 'ROLE_ADMIN'
            ],
            [
                'allow' => true,
                'action' => 'read',
                'role' => 'ROLE_ADMIN'
            ],
            [
                'allow' => true,
                'action' => 'read',
                'role' => env('OPENCAST_ROLE_USER')
            ],
            [
                'allow' => true,
                'action' => 'write',
                'role' => env('OPENCAST_ROLE_USER')
            ],
        ]);

        $uri = env('OPENCAST_URL') . '/api/series';

        try {
            $response = Http::withoutVerifying()
                ->withBasicAuth(env('OPENCAST_USER' ), env('OPENCAST_PASSWORD'))
                ->attach('metadata', $metadata)
                ->attach('acl',$acl)
                ->post($uri);
            $this->info('ACK');
            $this->info($response->status());
            $this->info($response->object()->identifier);
        } catch (RequestException $exception)
        {
            $this->info('NACK');
            $this->info($exception);
        }
        return 0;
    }
}
