@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h1>Login</h1>
    <form method="post" action="{{ route('landlord.login') }}">
        @csrf
        <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password">
        </div>
        <button type="submit">Login</button>
        <a href="{{ route('landlord.password.request') }}">Forgot Password</a>
    </form>
@endsection
