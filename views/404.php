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
    <section class="container mx-auto my-4 text-center" style="max-width:60%">
        <img src="./images/404.png" alt="signup image" width="50%" class="mb-2">
        <h2 class="poppins-extrabold hero-text text-primary">Oops!</h2>
        <p style="text-align:center">This page is not found <br> <a href="/authentication_app">Go back to home</a></p>
    </section>
    <?php 
        require_once('./components/footer.php');
    ?>
    <script src="./js/signup.js"></script>
</body>
</html>