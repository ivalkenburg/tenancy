@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <h1>Reset Password</h1>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>
@endsection
