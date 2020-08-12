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
     * @param object $queueable
     * @return bool
     */
    protected function isTenantAware(object $queueable): bool
    {
        if (!Tenant::isMultitenancyEnabled()) {
            return false;
        }

        return parent::isTenantAware($queueable);
    }
}
