<section class="centralize-comunicacao py-5">
    <div class="container">
        <div class="row align-items-center gy-4">
            <!-- Texto explicativo -->
            <div class="col-lg-6">
                <h2 class="cc-title">Centralize sua comunicação</h2>
                <p class="cc-subtitle">Com mais eficiência,<br>e produtividade para sua empresa</p>
                <p class="cc-desc">
                    Automatize suas vendas e melhore a eficiência do atendimento com nosso software
                    completo para WhatsApp. Ofereça um atendimento rápido, organizado e de alta qualidade aos seus
                    clientes!
                </p>
                <a href="#" class="btn btn-primary cc-cta">Conheça mais</a>
            </div>

            <!-- Vídeo ao lado -->
            <div class="col-lg-6 text-center">
                <video class="cc-video img-fluid" autoplay muted loop playsinline>
                    <source src="https://www.kubee.com.br/wp-content/uploads/2025/08/WhatsApp-Video-2025-08-29-at-21.21.51.mp4" type="video/mp4">
                    Seu navegador não suporta a reprodução de vídeo.
                </video>
            </div>
        </div>

        <!-- Botões ou cards lineares abaixo -->
        <div class="d-flex flex-wrap justify-content-center mt-4 cc-buttons">
            <?php
            $q = new WP_Query([
                'post_type'      => 'cc_botao',
                'posts_per_page' => 4,
                'orderby'        => 'menu_order title',
                'order'          => 'ASC',
            ]);
            if ($q->have_posts()):
                while ($q->have_posts()): $q->the_post();
                    $texto = get_post_meta(get_the_ID(), '_cc_texto', true) ?: get_the_title();
                    $link  = get_post_meta(get_the_ID(), '_cc_link', true) ?: '#';
                    $imgID = (int) get_post_meta(get_the_ID(), '_cc_image_id', true);
                    $img   = $imgID ? wp_get_attachment_image_url($imgID, 'medium') : get_template_directory_uri() . '/assets/img/robo-chat.png';
            ?>
                    <a href="<?php echo esc_url($link); ?>">
                        <div class="cc-small-card mx-2 my-2">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($texto); ?>">
                            <span><?php echo esc_html($texto); ?></span>
                        </div>
                    </a>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
    </div>
</section>
