<?php
get_header();

// Pegando os campos do Customizer
$banner_title    = get_theme_mod('kubee_banner_title', 'atendimentos e vendas para equipes de alta performance');
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
                <p class="mb-1 banner-subtitle"><?php echo esc_html($banner_subtitle); ?></p>
                <h1 class="fw-bold mb-3 banner-title"><?php echo esc_html($banner_title); ?></h1>
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
        }, 8000);
    }
});
</script>

<?php get_footer(); ?>
