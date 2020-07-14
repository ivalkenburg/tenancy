<?php

namespace App\Providers;

use App\Events\TestEvent;
use App\Listeners\TestListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TestEvent::class => [
            TestListener::class
        ]
    ];
}
