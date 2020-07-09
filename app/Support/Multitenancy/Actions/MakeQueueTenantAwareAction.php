<?php

namespace App\Support\Multitenancy\Actions;

use App\Support\Multitenancy\Models\Tenant;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Notifications\SendQueuedNotifications;

class MakeQueueTenantAwareAction extends \Spatie\Multitenancy\Actions\MakeQueueTenantAwareAction
{
    /**
     * @param object $job
     * @return bool
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
        }

        return parent::isTenantAware($job);
    }
}
