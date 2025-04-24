<?php 
        require_once('./components/navbar.php');
    ?>
    <section class="container">
        <div class="text-center mt-5">
            <h2 class="poppins-extrabold hero-text text-primary">Hello <?php echo SessionManager::get('email'); ?></h2>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
?>