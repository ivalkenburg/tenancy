<?php

namespace App\Models;

use App\Support\Multitenancy\Traits\TenantAware;
use App\Traits\UsesUuid;

class Activity extends \Spatie\Activitylog\Models\Activity
{
    use UsesUuid, TenantAware;
}
