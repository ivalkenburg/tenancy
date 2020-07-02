<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $tenant->name }} ({{ $tenant->domain }}) - Edit Tenant</title>
</head>
<body>
<h1>Edit {{ $tenant->name }}</h1>
<form method="post" action="{{ route('tenants.update', $tenant->id) }}">
    @method('put')
    @csrf
    <div>
        <label for="domain">Domain</label>
        <input id="domain" type="text" name="domain" value="{{ $tenant->domain }}">
    </div>
    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="{{ $tenant->name }}">
    </div>
    <button type="submit">Update</button>
</form>
</body>
</html>
