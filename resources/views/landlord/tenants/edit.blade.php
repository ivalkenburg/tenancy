@extends('layouts.app')

@section('title', "{$tenant->name} - Edit Tenant")

@section('content')
    <h1>Edit {{ $tenant->name }}</h1>
    <form method="post" action="{{ route('landlord.tenants.update', $tenant->id) }}">
        @method('put')
        @csrf
        <div>
            <label for="domain">Domain</label>
            <input id="domain" type="text" name="domain" value="{{ $tenant->domain }}" required>
        </div>
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ $tenant->name }}" required>
        </div>
        <button type="submit">Update</button>
    </form>
    <h2>Users</h2>
    <ul>
        @foreach($users as $user)
            <li>
                <form style="display: inline" action="{{ route('landlord.tenants.login', [$tenant->id, $user->id]) }}">
                    <button type="submit">L</button>
                </form>
                <span>{{ $user->name }}</span>
            </li>
        @endforeach
    </ul>
@endsection
