@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <h1>{{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'Welcome' }}</h1>
    <ul>
        @guest
            <li>
                <a href="{{ route('login') }}">Login</a>
            </li>
            <li>
                <a href="{{ route('register') }}">Register</a>
            </li>
        @else
            <li>
                <a href="{{ route('mail') }}">Send Mail</a>
            </li>
            <li>
                <a href="{{ route('job') }}">Dispatch Job</a>
            </li>
            <li>
                <a href="{{ route('settings') }}">Settings</a>
            </li>
            <li>
                <form id="logout" method="post" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
                </form>
            </li>
        @endguest
        <li>
            <a href="{{ route('cache') }}">Cached Value {{ cache('cached_value') }}</a>
        </li>
    </ul>
@endsection
