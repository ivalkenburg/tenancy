@extends('layouts.app')

@section('title', 'Home - Landlord')

@section('content')
    <h1>Home - Landlord</h1>
    <ul>
        <li>
            <a href="{{ route('landlord.tenants.index') }}">Tenants</a>
        </li>
        <li>
            <a href="{{ route('horizon.index') }}">Horizon</a>
        </li>
        <li>
            <a href="{{ route('landlord.notification') }}">Notification</a>
        </li>
        <li>
            <a href="{{ route('landlord.mail') }}">Mail</a>
        </li>
        <li>
            @if(auth()->user()->hasTotpEnabled())
                <form id="disable-totp" method="post" action="{{ route('totp.disable') }}">
                    @csrf
                    <a href="#" onclick="document.getElementById('disable-totp').submit()">Disable Totp</a>
                </form>
            @else
                <a href="{{ route('totp.enable', [], true) }}">Enable Totp</a>
            @endif
        </li>
        <li>
            <form id="logout" method="POST" action="{{ route('landlord.logout') }}">
                @csrf
                <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
            </form>
        </li>
    </ul>
@endsection
