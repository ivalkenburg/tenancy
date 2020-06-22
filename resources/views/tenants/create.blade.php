<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Tenant</title>
</head>
<body>
<h1>Create Tenant</h1>
<form method="post" action="{{ route('tenants.store') }}">
    {{ csrf_field() }}
    <div>
        <label for="domain">Domain</label>
        <input id="domain" type="text" name="domain">
    </div>
    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="name">
    </div>
    <button type="submit">Create</button>
</form>
</body>
</html>
