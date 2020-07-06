<?php

namespace Tests\Feature;

use App\Helpers\Multitenancy\Models\Tenant;
use Tests\TestCase;

class TenantSwitchingTest extends TestCase
{
    /** @test */
    public function can_switch_between_tenant_context()
    {
        $tenantA = factory(Tenant::class)->create();
        $tenantB = factory(Tenant::class)->create();

        $tenantA->makeCurrent();

        $this->assertEquals(Tenant::currentId(), $tenantA->id);

        $tenantB->makeCurrent();

        $this->assertEquals(Tenant::currentId(), $tenantB->id);
    }
}
