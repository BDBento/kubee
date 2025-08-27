<section class="negocios-lista-home" id="nossos-servicos">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-title">Explore <span>nossos serviços</span></h2>
      <p class="section-desc">Tudo o que sua equipe precisa para otimizar processos e atender melhor.</p>
    </div>

    <div class="row g-4">
      <?php
      $q = new WP_Query([
        'post_type'      => 'negocios',
        'posts_per_page' => 6, // use -1 se quiser todos
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
      ]);

      if ($q->have_posts()):
        while ($q->have_posts()):
          $q->the_post();
          $icon = get_post_meta(get_the_ID(), '_negocio_icon_url', true);
          $subt = get_post_meta(get_the_ID(), '_negocio_subtitulo', true);
          $res  = get_post_meta(get_the_ID(), '_negocio_resumo', true);
          ?>
          <div class="col-md-4">
            <article class="negocio-card h-100">
              <header class="negocio-header d-flex align-items-center gap-3">
                <?php if ($icon): ?>
                  <div class="negocio-icon">
                    <img
                      src="<?php echo esc_url($icon); ?>"
                      alt="<?php echo esc_attr(get_the_title()); ?>"
                      loading="lazy"
                      class="negocio-icon-img"
                    >
                  </div>
                <?php endif; ?>

                <div class="negocio-title">
                 	<h3><?php the_title(); ?></h3>
                </div>
              </header>

              <?php if ($subt): ?>
                <h4 class="h6 mt-3"><?php echo esc_html($subt); ?></h4>
              <?php endif; ?>

              <?php if ($res): ?>
                <p class="mt-2 mb-0"><?php echo esc_html($res); ?></p>
              <?php endif; ?>
            </article>
          </div>
          <?php
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>
  </div>
</section>