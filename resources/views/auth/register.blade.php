@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h1>Register</h1>
    <form method="post" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" required>
        </div>
        <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Password Confirmation</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>
@endsection
