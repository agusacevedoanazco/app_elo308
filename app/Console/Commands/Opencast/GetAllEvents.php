<?php

namespace App\Console\Commands\Opencast;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetAllEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opencast:getallevents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hole alle videos vom server';

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

        $request = Http::withoutVerifying()
            ->withBasicAuth(env('OPENCAST_USER'),env('OPENCAST_PASSWORD'))
            ->get($uri);

        if ($request->successful())
        {
            $videos = $request->object();
            $idx = 1;
            foreach ($videos as $video) {
                $this->info('Video '.$idx.': '.$video->title);
                $idx++;
            }
            return 0;
        }
        else
        {
            $this->info('Error');
            return 1;
        }
    }
}
