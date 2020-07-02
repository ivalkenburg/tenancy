<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
</head>
<body>
<pre>
@json($settings, JSON_PRETTY_PRINT)
</pre>
<form method="post" action="{{ route('settings') }}">
    @csrf
    <input type="text" name="foobar" value="{{ settings()->get('foobar', '') }}">
    <button type="submit">Update</button>
</form>
<hr/>
<a href="{{ route('welcome') }}">Go To Welcome</a>
</body>
</html>
