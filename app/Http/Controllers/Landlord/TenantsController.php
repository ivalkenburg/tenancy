<?php

namespace App\Http\Controllers\Landlord;

use App\Support\Multitenancy\Models\Tenant;
use App\Models\User;
use App\Support\Multitenancy\Rules\ValidDomains;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TenantsController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('landlord.tenants.index', [
            'tenants' => Tenant::all()
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('landlord.tenants.create');
    }

    /**
     * @param Tenant $tenant
     * @return \Illuminate\View\View
     */
    public function edit(Tenant $tenant)
    {
        $users = User::byTenant($tenant)->get();

        return view('landlord.tenants.edit', compact('tenant', 'users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'domains' => [new ValidDomains],
        ]);

        Tenant::create($request->only('domains', 'name'));

        return $request->expectsJson()
            ? response()->json(['redirect' => route('landlord.tenants.index')])
            : redirect(route('landlord.tenants.index'));
    }

    /**
     * @param Tenant $tenant
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Tenant $tenant, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'domains' => [ValidDomains::forTenant($tenant)],
        ]);

        $tenant->update($request->only('name', 'domains'));

        return $request->expectsJson()
            ? response()->json(['redirect' => route('landlord.tenants.index')])
            : redirect(route('landlord.tenants.index'));
    }

    /**
     * @param Tenant $tenant
     * @param string $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Tenant $tenant, $user)
    {
        $token = Str::random(64);
        $tenant->execute(fn() => Cache::put($token, User::findOrFail($user)->id, 5));

        return redirect($tenant->url("/login/{$token}", false));
    }

    /**
     * @param Tenant $tenant
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return redirect(route('landlord.tenants.index'));
    }
}
