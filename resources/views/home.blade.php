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
            @if(\App\Helpers\can('send.mails'))
                <li>
                    <a href="{{ route('mail') }}">Send Mail</a>
                </li>
            @endif
            @if(\App\Helpers\can('dispatch.jobs'))
                <li>
                    <a href="{{ route('job') }}">Dispatch Job</a>
                </li>
            @endif
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
        @if(Tenant::isMultitenancyEnabled())
            <li>
                <a href="{{ route('landlord.home') }}">Landlord Home</a>
            </li>
        @endif
    </ul>
@endsection
