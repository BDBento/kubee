<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>

  <!-- Open Graph / Facebook / Instagram -->
  <meta property="og:title" content="Kube - Solução simples e eficiente para o seu dia a dia" />
  <meta property="og:description" content="O Kube deixa sua rotina mais prática. Fácil de usar, rápido e direto ao ponto. Confira os depoimentos de quem já usa." />
  <meta property="og:image" content="https://www.kubee.com.br/wp-content/themes/kubee/assets/img/kubbe-logo-transparente.png" />
  <meta property="og:url" content="https://www.kubee.com.br/" />
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="pt_BR" />
  <meta property="og:site_name" content="Kube" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Kube - Solução simples e eficiente para o seu dia a dia" />
  <meta name="twitter:description" content="O Kube deixa sua rotina mais prática. Fácil de usar, rápido e direto ao ponto." />
  <meta name="twitter:image" content="https://www.kubee.com.br/wp-content/themes/kubee/assets/img/kubbe-logo-transparente.png" />
  <meta name="twitter:site" content="@seuusuario" />

</head>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CTMZ1SX6L3"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-CTMZ1SX6L3');
</script>

<body <?php body_class(); ?>>

  <header class="navbar navbar-expand-md navbar-dark bg-dark py-3">
    <div class="container">
      <!-- Logo -->
      <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand d-flex align-items-center">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-kube-horizontal.png"
          alt="Kubee Logo" style="height:50px;width:189px">
      </a>

      <button class="navbar-toggler" type="button"
        aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegação">
        <span class="navbar-toggler-icon"></span>
      </button>

      
      <!-- Menu + CTA -->
      <div class="collapse navbar-collapse" id="mainNav">
        <?php
        wp_nav_menu([
          'theme_location' => 'main_menu',
          'container'      => false,
          'menu_class'     => 'navbar-nav ms-auto gap-3',
          'fallback_cb'    => false,
        ]);
        ?>

        <?php $whatsapp = get_theme_mod('kubee_whatsapp_number', '5567999999999'); ?>
        <!-- CTA visível dentro do collapse no mobile -->
        <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank"
          class="btn btn-primary ms-md-3 mt-3 mt-md-0 d-inline-flex align-items-center gap-2 rounded-3">
          <i class="bi bi-whatsapp"></i> ENTRE EM CONTATO
        </a>
      </div>
    </div>
  </header>