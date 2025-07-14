<footer class="footer-site">
    <div class="footer-top">
        <div class="container">
            <div class="row align-items-center py-5">
                <!-- Logo -->
                <div class="col-12 col-md-3 mb-4 mb-md-0 text-center text-md-start">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-footer.png" alt="LevelWork Logo" style="max-width: 145px;">
                </div>
                <!-- Menus -->
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <h6 class="footer-title">Empresa</h6>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_menu_1',
                        'menu_class'     => 'footer-menu list-unstyled',
                        'container'      => false
                    ]);
                    ?>
                </div>
                <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <h6 class="footer-title">Empresa</h6>
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer_menu_2',
                        'menu_class'     => 'footer-menu list-unstyled',
                        'container'      => false
                    ]);
                    ?>
                </div>
                <!-- Newsletter -->
                <div class="col-12 col-md-3">
                    <h6 class="footer-title">Se inscreva</h6>
                    <form class="footer-newsletter" action="#" method="post">
                        <div class="d-flex gap-2">
                            <input type="email" class="form-control" name="newsletter" placeholder="Seu e-mail" required style="background:transparent;color:#fff;">
                            <button type="submit" class="btn btn-newsletter">→</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3">
        <small>@ <?php echo date('Y'); ?> LevelWork. Todos os direitos reservados.</small>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>