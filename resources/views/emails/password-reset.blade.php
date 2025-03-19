<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body>
    <h1>Reset Your Password</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Click the link below to reset your password:</p>
    
    <a href="{{ url('reset-password/'.$token.'?email='.$email) }}">Reset Password</a>
    
    <p>This password reset link will expire in 60 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    
    <p>Regards,<br>AuthoLoc<span class="text-yellow-500">Pro</span> System</p>
</body>
</html>