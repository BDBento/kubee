<?php get_header(); ?>

<?php
$banner_title    = get_theme_mod('kubee_banner_title', 'Atendimento Centralizado e Eficiente');
$banner_subtitle = get_theme_mod('kubee_banner_subtitle', 'Plataforma que unifica');
$banner_desc     = get_theme_mod('kubee_banner_desc', 'com inteligência artificial e chatbots');
$whatsapp        = get_theme_mod('kubee_whatsapp_number', '5599999999999');

$banner_imgs = [];
for ($i = 1; $i <= 3; $i++) {
    $img = get_theme_mod("kubee_banner_img_$i");
    if ($img) $banner_imgs[] = esc_url($img);
}
if (empty($banner_imgs)) {
    $banner_imgs = [get_template_directory_uri() . '/assets/img/banner-default.png'];
}
?>

<section class="banner-home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 banner-content">
                <h1 class="banner-title"><?php echo esc_html($banner_title); ?></h1>
                <p class="banner-subtitle"><?php echo esc_html($banner_subtitle); ?></p>
                <p class="banner-desc"><?php echo esc_html($banner_desc); ?></p>
                <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" class="btn btn-primary">
                    <i class="bi bi-whatsapp"></i> COMECE AGORA
                </a>
            </div>
            <div class="col-lg-6 banner-images">
                <?php foreach ($banner_imgs as $img): ?>
                    <div class="banner-img">
                        <img src="<?php echo esc_url($img); ?>" alt="">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="negocios-lista-home">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Explore <span>nossos serviços</span></h2>
            <p class="section-desc">Tudo o que sua equipe precisa para otimizar processos e atender melhor.</p>
        </div>
        <div class="row g-4">
            <?php
            $q = new WP_Query(['post_type' => 'negocios', 'posts_per_page' => 6]);
            if ($q->have_posts()):
                while ($q->have_posts()): $q->the_post();
                    $icon = get_post_meta(get_the_ID(), '_negocio_icon_url', true);
                    $subt = get_post_meta(get_the_ID(), '_negocio_subtitulo', true);
                    $res  = get_post_meta(get_the_ID(), '_negocio_resumo', true);
            ?>
                    <div class="col-md-4">
                        <div class="negocio-card">
                            <div class="negocio-header d-flex align-items-center">
                                <div class="negocio-icon">
                                    <?php if ($icon): ?><img src="<?php echo esc_url($icon); ?>" alt="" class="negocio-icon"><?php endif; ?>
                                </div>
                                <div class="negocio-title">
                                    <h3><?php the_title(); ?></h3>
                                </div>
                            </div>
                            <?php if ($subt): ?><h4><?php echo esc_html($subt); ?></h4><?php endif; ?>
                            <p><?php echo esc_html($res); ?></p>

                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>


<section class="clientes-lista-home">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Conheça alguns de <span>nossos clientes.</span></h2>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $qp = new WP_Query(['post_type' => 'clientes', 'posts_per_page' => 12]);
            if ($qp->have_posts()):
                while ($qp->have_posts()): $qp->the_post();
                    $media = get_post_meta(get_the_ID(), '_cliente_media_id', true);
                    $link = get_post_meta(get_the_ID(), '_cliente_link', true);
                    $img = $media ? wp_get_attachment_image_url($media, 'medium') : '';
            ?>
                    <div class="col-6 col-md-3">
                        <div class="cliente-card">
                            <?php if ($img): ?>
                                <?php if ($link): ?>
                                    <a href="<?php echo esc_url($link); ?>" target="_blank">
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php the_title(); ?>">
                                    </a>
                                <?php else: ?>
                                    <img src="<?php echo esc_url($img); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            <?php endif; ?>
                            <div class="cliente-name"><?php the_title(); ?></div>
                        </div>
                    </div>
            <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>



<?php get_footer(); ?>