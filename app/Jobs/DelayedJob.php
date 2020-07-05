<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DelayedJob implements ShouldQueue
{
    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $sleep;

    /**
     * @param int $sleep
     * @return void
     */
    public function __construct($sleep)
    {
        $this->sleep = $sleep;
    }

    /**
     * @return void
     */
    public function handle()
    {
        info('DelayedJob', ['route' => route('welcome'), 'url' => url('/hello/world'), 'tenant' => route('landlord.tenants.create')]);

        sleep($this->sleep);
    }
}
