<?php

namespace App\Support\Multitenancy\Actions;

use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Notifications\SendQueuedNotifications;
use Spatie\Multitenancy\Jobs\NotTenantAware;
use Spatie\Multitenancy\Jobs\TenantAware;

class MakeQueueTenantAwareAction extends \Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction
{
    /**
     * @param object $job
     * @return bool
     * @throws \ReflectionException
     */
    protected function isTenantAware(object $job): bool
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return false;
        }

        switch(get_class($job)) {
            case SendQueuedMailable::class:
                $job = $job->mailable;
                break;
            case SendQueuedNotifications::class:
                $job = $job->notification;
                break;
            case CallQueuedListener::class:
                $job = $job->class;
                break;
        }

        $reflection = new \ReflectionClass($job);

        if ($reflection->implementsInterface(TenantAware::class)) {
            return true;
        }

        if ($reflection->implementsInterface(NotTenantAware::class)) {
            return false;
        }

        return config('multitenancy.queues_are_tenant_aware_by_default') === true;
    }
}
