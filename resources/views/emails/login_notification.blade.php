<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Login Detected</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>Hello, {{ $user->first_name }}!</h2>

    <p>We noticed a new login to your <strong>Econnect</strong> account.</p>

    <p><strong>Login Details:</strong></p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>IP Address:</strong> {{ $ip }}</li>
        <li><strong>Time:</strong> {{ $time }}</li>
    </ul>

    <p>If this was you, no further action is needed.</p>
    <p>If this wasn't you, please <a href="{{ url('/login') }}">secure your account</a> immediately.</p>

    <br>
    <p>— The Econnect Security Team</p>
</body>
</html>
