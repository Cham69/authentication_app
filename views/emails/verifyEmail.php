<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
    <div style="max-width: 500px; margin: auto; padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #333;">Hey, <?php echo htmlspecialchars($username); ?></h2>
        <p style="color: #555; font-size: 16px;">
            Welcome to our service! Your verification code is 
            <strong><?php echo htmlspecialchars($verification_code); ?></strong>.
            Use this to verify your email address or simply click the following link.
        </p>

        <a href="https://yourdomain.com/verify?code=123456" 
           style="display: inline-block; padding: 10px 20px; background-color: #0d6efd; color: #fff; text-decoration: none; border-radius: 5px; margin: 20px 0;">
           Verify my email
        </a>

        <p style="color: #999; font-size: 14px; margin-top: 20px;">
            If you did not request this email, please ignore it.
        </p>
    </div>
</body>
</html>
