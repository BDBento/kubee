<?php
$banner_title = get_theme_mod('kubee_banner_title', 'Atendimento Centralizado e Eficiente');
$banner_subtitle = get_theme_mod('kubee_banner_subtitle', 'Plataforma que unifica');
$banner_desc = get_theme_mod('kubee_banner_desc', 'com inteligência artificial e chatbots');
$whatsapp = get_theme_mod('kubee_whatsapp_number', '5599999999999');

$banner_imgs = [];
for ($i = 1; $i <= 3; $i++) {
    $img = get_theme_mod("kubee_banner_img_$i");
    if ($img)
        $banner_imgs[] = esc_url($img);
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

            <div class="col-lg-6">
                <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <!-- indicators -->
                    <div class="carousel-indicators">
                        <?php foreach ($banner_imgs as $i => $img): ?>
                            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="<?php echo $i; ?>"
                                class="<?php echo $i === 0 ? 'active' : ''; ?>"
                                aria-current="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>

                    <!-- slides -->
                    <div class="carousel-inner">
                        <?php foreach ($banner_imgs as $i => $img): ?>
                            <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo esc_url($img); ?>" class="d-block w-100 rounded-4"
                                    style="height:310px;object-fit:contain;background:#fff;"
                                    alt="Banner <?php echo $i + 1; ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Próximo</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>