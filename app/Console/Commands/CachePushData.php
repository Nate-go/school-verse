<?php

namespace App\Console\Commands;

use App\Models\Grade;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CachePushData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-push-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $grades = Grade::all();

        foreach ($grades as $grade) {
            Redis::set('grade-' . $grade->id, $grade);
        }
    }
}
