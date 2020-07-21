@extends('layouts.app')

@section('title', 'TOTP Required')

@section('content')
    <h1>Totp Required</h1>
    <p>
        <a href="{{ route('home') }}">Go back home</a>
    </p>
@endsection
