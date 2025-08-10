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
                while ($q->have_posts()):
                    $q->the_post();
                    $icon = get_post_meta(get_the_ID(), '_negocio_icon_url', true);
                    $subt = get_post_meta(get_the_ID(), '_negocio_subtitulo', true);
                    $res = get_post_meta(get_the_ID(), '_negocio_resumo', true);
                    ?>
                    <div class="col-md-4">
                        <div class="negocio-card">
                            <div class="negocio-header d-flex align-items-center">
                                <div class="negocio-icon">
                                    <?php if ($icon): ?><img src="<?php echo esc_url($icon); ?>" alt=""
                                            class="negocio-icon"><?php endif; ?>
                                </div>
                                <div class="negocio-title">
                                    <h3><?php the_title(); ?></h3>
                                </div>
                            </div>
                            <?php if ($subt): ?>
                                <h4><?php echo esc_html($subt); ?></h4><?php endif; ?>
                            <p><?php echo esc_html($res); ?></p>

                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif; ?>
        </div>
    </div>
</section>