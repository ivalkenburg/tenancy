@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <pre>@json($settings, JSON_PRETTY_PRINT)</pre>
    <form method="post" action="{{ route('settings') }}">
        @csrf
        <label for="foobar">Foobar</label>
        <input id="foobar" type="text" name="foobar" value="{{ settings()->get('foobar', '') }}">
        <button type="submit">Update</button>
    </form>
    <p>
        <a href="{{ route('home') }}">Go To Home</a>
    </p>
@endsection
