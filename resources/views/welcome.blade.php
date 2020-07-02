<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
<h1>{{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'Welcome' }}</h1>
<hr/>
<ul>
    @if (Route::has('login'))
        @auth
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}">Login</a>
            </li>

            @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}">Register</a>
                </li>
            @endif
        @endauth
    @endif
    <li>
        <a href="{{ route('mail') }}">Send Mail</a>
    </li>
    <li>
        <a href="{{ route('job') }}">Dispatch Job</a>
    </li>
    <li>
        <a href="{{ route('cache') }}">Cache Value {{ $cached }}</a>
    </li>
    <li>
        <a href="{{ route('settings') }}">Settings</a>
    </li>
</ul>
</body>
</html>
