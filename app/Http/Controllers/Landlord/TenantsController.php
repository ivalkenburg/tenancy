<?php

namespace App\Http\Controllers\Landlord;

use App\Helpers\Tenancy\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class TenantsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('tenants.index', [
            'tenants' => Tenant::all()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tenants.create');
    }

    /**
     * @param Tenant $tenant
     * @return \Illuminate\View\View
     */
    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', Rule::unique('tenants')],
            'name' => ['required', 'string'],
        ]);

        Tenant::create($validated);

        return redirect(route('tenants.index'));
    }

    /**
     * @param Tenant $tenant
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Tenant $tenant, Request $request)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', Rule::unique('tenants')->ignore($tenant->id)],
            'name' => ['required', 'string'],
        ]);

        $tenant->update($validated);

        return redirect(route('tenants.index'));
    }

    /**
     * @param Tenant $tenant
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect(route('tenants.index'));
    }
}
