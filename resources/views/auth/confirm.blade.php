@extends('layouts.app')

@section('title', 'Confirm User Account')

@section('content')
    <h1>Confirm User</h1>
    <form method="post" action="{{ route('confirm.post') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" value="{{ old('email', $email) }}" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation">
        </div>
        <button type="submit">Confirm User Account</button>
    </form>
@endsection
