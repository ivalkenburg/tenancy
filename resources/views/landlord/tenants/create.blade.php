@extends('layouts.app')

@section('title', 'Create Tenant')

@section('content')
    <h1>Create Tenant</h1>
    <form method="post" action="{{ route('landlord.tenants.store') }}">
        @csrf
        <div>
            <label for="domain">Domain</label>
            <input id="domain" type="text" name="domain" required>
        </div>
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>
        </div>
        <button type="submit">Create</button>
    </form>
@endsection
