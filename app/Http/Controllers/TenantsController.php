<?php

namespace App\Http\Controllers;

use App\Helpers\Tenancy\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TenantsController extends Controller
{
    public function index()
    {
        return view('tenants.index', [
            'tenants' => Tenant::all()
        ]);
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', Rule::unique('tenants')],
            'name' => ['required', 'string'],
        ]);

        $tenant = Tenant::create($validated);

        return redirect(route('tenants.index'));
    }

    public function update(Tenant $tenant, Request $request)
    {
        $validated = $request->validate([
            'domain' => ['required', 'string', Rule::unique('tenants')->ignore($tenant->id)],
            'name' => ['required', 'string'],
        ]);

        $tenant->update($validated);

        return redirect(route('tenants.index'));
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect(route('tenants.index'));
    }
}
