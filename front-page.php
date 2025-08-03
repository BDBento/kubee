<?php
get_header();

// Pegando os campos do Customizer
$banner_title    = get_theme_mod('kubee_banner_title', 'Atendimento Centralizado e Eficiente');
$banner_subtitle = get_theme_mod('kubee_banner_subtitle', 'Plataforma que unifica');
$banner_desc     = get_theme_mod('kubee_banner_desc', 'com inteligência artificial e chatbots');
$whatsapp        = get_theme_mod('kubee_whatsapp_number', '5599999999999');

// Imagens do banner (array)
$banner_imgs = [];
for ($i = 1; $i <= 3; $i++) {
    $img = get_theme_mod("kubee_banner_img_$i");
    if ($img) $banner_imgs[] = esc_url($img);
}
// Fallback caso não tenha imagens no customizer
if (empty($banner_imgs)) {
    $banner_imgs = [ get_template_directory_uri().'/assets/img/banner-default.png' ];
}
?>

<section class="banner-home d-flex align-items-center">
    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white">
                <h1 class="fw-bold mb-3 banner-title"><?php echo esc_html($banner_title); ?></h1>
                <p class="mb-1 banner-subtitle"><?php echo esc_html($banner_subtitle); ?></p>
                <p class="mb-4 banner-desc"><?php echo esc_html($banner_desc); ?></p>
                <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" target="_blank" class="btn btn-primary btn-lg d-inline-flex align-items-center gap-2" style="border-radius:12px;">
                    <i class="bi bi-whatsapp"></i> COMECE AGORA
                </a>
            </div>
            <div class="col-lg-6 d-flex justify-content-center">
                <div id="banner-home-img" class="img-wrapper" style="max-width:480px;">
                    <img src="<?php echo esc_url($banner_imgs[0]); ?>" alt="Banner" class="img-fluid rounded-4 shadow" style="transition:opacity .8s;min-height:320px;background:#fff;">
                </div>
            </div>
        </div>
    </div>
    <div class="banner-overlay"></div>
</section>

<section class="negocios-lista-home py-5" style="background-color:#F9F9F9;">
    
    <div class="container" style="padding: 60px 0;">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold mb-3 negocios-lista-home-titulo">Explore <span>nossos serviços</span></h2>
                <p class="mb-4">Tudo o que sua equipe precisa para otimizar processos e atender melhor.</br>Todas as ferramentas em um só lugar pelo custo de uma. Veja:</p>
            </div>
            <?php
            $negocios_query = new WP_Query([
                'post_type' => 'negocios',
                'posts_per_page' => 6
            ]);
            if ($negocios_query->have_posts()):
                while ($negocios_query->have_posts()): $negocios_query->the_post();
                    $icon_url = get_post_meta(get_the_ID(), '_negocio_icon_url', true);
                    $resumo = get_post_meta(get_the_ID(), '_negocio_resumo', true);
                    ?>
                    <div class="col-md-4">
                        <div class="card negocio-card h-100 shadow-sm border-0">
                            <div class="card-body d-flex flex-column align-items-start" style="min-height:200px;">
                                <?php if ($icon_url): ?>
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="" style="width:38px; height:38px; margin-bottom:15px;">
                                <?php endif; ?>
                                <h3 class="h6 fw-bold mb-2"><?php the_title(); ?></h3>
                                <p class="mb-0"><?php echo esc_html($resumo); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <div class="col-12 text-center">Nenhum negócio encontrado.</div>
            <?php endif; ?>
        </div>
    </div>
</section>


<section class="clientes-lista-home py-5">
    <div class="container">
        <div class="col-lg-12 text-center mb-5">
                <h2 class="fw-bold mb-3">Nossos Clientes</h2>
                <p class="mb-4">Conheça alguns dos nossos clientes.</p>
            </div>
        <div class="row g-4">
            <?php
            $clientes_query = new WP_Query([
                'post_type' => 'clientes',
                'posts_per_page' => 12
            ]);
            if ($clientes_query->have_posts()):
                while ($clientes_query->have_posts()): $clientes_query->the_post(); ?>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="card border-0 shadow-sm text-center py-3 px-2 h-100">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" style="max-width: 110px; max-height: 80px; margin:0 auto 12px auto;">
                            <?php endif; ?>
                            <div style="font-weight: 600; font-size: 1.02rem;"><?php the_title(); ?></div>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <div class="col-12 text-center">Nenhum cliente cadastrado.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const images = <?php echo json_encode($banner_imgs); ?>;
    let index = 0;
    const bannerImg = document.querySelector('#banner-home-img img');
    if (images.length > 1 && bannerImg) {
        setInterval(function() {
            index = (index + 1) % images.length;
            bannerImg.style.opacity = 0;
            setTimeout(function(){
                bannerImg.src = images[index];
                bannerImg.style.opacity = 1;
            }, 600);
        }, 5000);
    }
});
</script>

<?php get_footer(); ?>
