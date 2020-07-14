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
            <a href="{{ route('landlord.event') }}">Event</a>
        </li>
        <li>
            <form id="logout" method="POST" action="{{ route('landlord.logout') }}">
                @csrf
                <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
            </form>
        </li>
    </ul>
@endsection
