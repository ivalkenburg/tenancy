@extends('layouts.app')

@section('title', 'Tenants')

@section('content')
    <h1>Tenants</h1>
    <p>
        <a href="{{ route('landlord.tenants.create') }}">Create Tenant</a>
    </p>
    <ul>
        @foreach($tenants as $tenant)
            <li>
                <form style="display: inline" action="{{ route('landlord.tenants.edit', $tenant->id) }}">
                    <button type="submit">E</button>
                </form>
                <form style="display: inline" method="post"
                      action="{{ route('landlord.tenants.destroy', $tenant->id) }}">
                    @csrf
                    @method('delete')
                    <button type="submit">D</button>
                </form>
                <a href="{{ $tenant->url(null, false) }}">{{ $tenant->name }}</a>
            </li>
        @endforeach
    </ul>
@endsection

