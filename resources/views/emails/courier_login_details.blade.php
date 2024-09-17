<!DOCTYPE html>
<html>
<head>
    <title> myLabs App -Your Courier Login Details</title>
</head>
<body>
    <h1>Welcome, {{ $name }}</h1>
    <p>Your account has been created successfully.</p>
    <p>Here are login details:</p>
    <ul>
        <li><strong>Username:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
   
    <p>Thank you!</p>
</body>
</html>