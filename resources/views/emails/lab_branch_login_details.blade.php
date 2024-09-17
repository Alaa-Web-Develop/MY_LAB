<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Details</title>
</head>
<body>
    <h1>Hello {{ $labBranch->name }},</h1>

    <p>Welcome to our system! Here are your login details:</p>

    <p><strong>Email:</strong> {{ $labBranch->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>You can log in using these credentials at the following link:</p>
    <a href="{{ url('/login') }}">Login Here</a>

    <p>Thank you!</p>
</body>
</html>