<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Authentication App</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php 
        require_once('./components/navbar.php');
    ?>
    <section class="container">
        <div class="text-center mt-5">
            <h2 class="poppins-extrabold hero-text text-primary">A Comprehensive User Authentication System</h2>
            <div class="mx-auto" style="max-width:800px;">
            <p style="text-align:center">This simple web application consists of user authentication with a comprehensive password policy applied. 
                The password must be strong enough to sign up properly.
                Password validation is active in both front-end and backend. Additionally, authentication is powered up with a dynamic reCAPTCHA.
            </p>
            </div>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
    ?>
</body>
</html>