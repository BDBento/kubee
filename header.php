<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="bg-dark text-white py-3">
  <div class="container d-flex justify-content-between align-items-center">
    
    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand d-flex align-items-center">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.svg" alt="Kubee Logo" style="height: 40px;">
    </a>

    <!-- Menu (padrão WP) -->
    <nav class="d-none d-md-block">
      <?php
      wp_nav_menu([
        'theme_location' => 'main_menu',
        'menu_class'     => 'nav gap-4', // adiciona espaçamento igual ao Bootstrap
        'container'      => false,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

    <!-- Botão WhatsApp -->
    <?php
$whatsapp = get_theme_mod('kubee_whatsapp_number', '5567999999999'); // valor padrão
?>
<a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank" class="btn btn-primary d-flex align-items-center gap-2 rounded-3">
  <i class="bi bi-whatsapp"></i> ENTRE EM CONTATO
</a>
  </div>
</header>