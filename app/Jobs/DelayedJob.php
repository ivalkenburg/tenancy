<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Multitenancy\Jobs\TenantAware;

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
        sleep($this->sleep);
    }
}
