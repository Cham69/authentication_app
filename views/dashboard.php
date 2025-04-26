<?php 
        require_once('./components/navbar.php');
    ?>
    <section class="container">
        <div class="text-center mt-5">
            <h4 class="poppins-semibold">Welcome back <?php echo SessionManager::get('first_name'); ?></h4>
        </div>
    </section>
    <?php 
        require_once('./components/footer.php');
?>