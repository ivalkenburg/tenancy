<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tenants</title>
</head>
<body>
<h1>Tenants</h1>
<p>
    <a href="{{ route('tenants.create') }}">Create Tenant</a>
</p>
<ul>
    @foreach($tenants as $tenant)
        <li>
            <form style="display: inline" action="{{ route('tenants.edit', $tenant->id) }}">
                <button type="submit">E</button>
            </form>
            <form style="display: inline" method="post" action="{{ route('tenants.destroy', $tenant->id) }}">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <button type="submit">D</button>
            </form>
            <span>{{ $tenant->name }} ({{ $tenant->domain }})</span>
        </li>
    @endforeach
</ul>
</body>
</html>
