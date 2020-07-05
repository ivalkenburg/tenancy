<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Mail</title>
</head>
<body>
    <h1>Hello {{ Tenant::isMultitenancyEnabled() ? Tenant::current()->name : 'Non-tenant' }}</h1>
    <ul>
        <li>Setting: {{ settings()->get('foobar') }}</li>
        <li>Cached value: {{ cache('cached_value') }}</li>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('landlord.tenants.index') }}">Tenants</a></li>
        <li><a href="{{ url('/hello/world') }}">Hello World (404)</a></li>
    </ul>
</body>
</html>
