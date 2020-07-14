<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activate Two-factor Authentication</title>
</head>
<body>
    <h1>Activate Two-factor Authentication</h1>
    <img src="{{ $qrCode }}" alt="{{ $secret }}">
    <pre>{{ $secret }}</pre>
    <form method="post" action="{{ route('totp.enable') }}">
        @csrf
        @if($redirect)
            <input type="hidden" name="redirect" value="{{ $redirect }}">
        @endif
        <label for="verification_code">Verification Code</label>
        <input type="text" id="verification_code" name="verification_code">
        <button type="submit">Verify Code</button>
    </form>
</body>
</html>
