@extends('layouts.app')

@section('title', 'Request Password Reset')

@section('content')
    <h1>Request Password Reset</h1>
    @if(session()->has('status'))
        <p>{{ session('status') }}</p>
    @endif
    <form method="post" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Request Password Reset Link</button>
    </form>
@endsection
