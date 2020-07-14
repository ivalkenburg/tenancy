<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Two-factor Authentication</title>
</head>
<body>
    <h1>Verify Two-factor Authentication</h1>
    @if($error)
        <p>Invalid code given.</p>
    @endif
    <form method="post" action="{{ $action }}">
        @csrf
        @foreach($credentials as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
        @if($remember)
            <input type="hidden" name="remember" value="on">
        @endif
        <div>
            <label for="code">Verification Code</label>
            <input id="code" type="text" name="{{ $codeInputName }}" required>
        </div>
        <button type="submit">Verify Two-factor Authentication Code</button>
    </form>
</body>
</html>
