<?php get_header(); ?>

<?php 
get_template_part('template-parts/banner-home');

get_template_part('template-parts/nossos-servicos'); 

get_template_part('template-parts/clientes-home');

get_template_part('template-parts/comunicacao-home');

get_template_part('template-parts/planos-home');

?>

<section class="depoimentos-home py-5">
  <div class="container">
    <div class="text-center mb-3">
      <h2 class="dep-title"><span>Depoimento</span> dos nossos clientes</h2>
      <p class="dep-sub">Relatos reais de clientes que alcançaram resultados excepcionais.<br>Veja abaixo:</p>
    </div>

    <?php
    // Busca depoimentos
    $qd = new WP_Query([
      'post_type'      => 'depoimentos',
      'posts_per_page' => -1,
      'orderby'        => 'menu_order date',
      'order'          => 'ASC'
    ]);

    // Monta array de cards prontos (para poder agrupar em slides)
    $cards = [];
    if ($qd->have_posts()):
      while ($qd->have_posts()): $qd->the_post();
        $cargo   = get_post_meta(get_the_ID(), '_dep_cargo', true);
        $nota    = (int) get_post_meta(get_the_ID(), '_dep_nota', true);
        $mediaID = (int) get_post_meta(get_the_ID(), '_dep_media_id', true);
        $avatar  = $mediaID ? wp_get_attachment_image_url($mediaID,'thumbnail') : '';
        ob_start(); ?>
          <article class="dep-card h-100">
            <div class="dep-text"><?php echo wpautop( esc_html( get_the_excerpt() ?: wp_strip_all_tags(get_the_content()) ) ); ?></div>
            <div class="dep-footer d-flex align-items-center">
              <div class="dep-avatar">
                <?php if($avatar): ?><img src="<?php echo esc_url($avatar); ?>" alt="<?php the_title_attribute(); ?>">
                <?php else: ?><span class="dep-avatar-fallback"></span><?php endif; ?>
              </div>
              <div class="ms-2">
                <div class="dep-name"><?php the_title(); ?></div>
                <?php if($cargo): ?><div class="dep-role"><?php echo esc_html($cargo); ?></div><?php endif; ?>
              </div>
              <div class="ms-auto dep-stars" aria-label="Nota <?php echo $nota; ?> de 5">
                <?php for($i=1;$i<=5;$i++): ?>
                  <span class="star <?php echo $i <= $nota ? 'on':'off'; ?>">★</span>
                <?php endfor; ?>
              </div>
            </div>
          </article>
        <?php
        $cards[] = ob_get_clean();
      endwhile; wp_reset_postdata();
    endif;

    $total = count($cards);

    // <= 3: grid simples
    if ($total <= 3): ?>
      <div class="row g-4 justify-content-center">
        <?php foreach ($cards as $html): ?>
          <div class="col-md-4"><?php echo $html; ?></div>
        <?php endforeach; ?>
      </div>

    <?php else:
      // > 3: carrossel (3 por slide)
      $slides = array_chunk($cards, 3);
      $cid = 'depCarousel'; ?>
      <div id="<?php echo $cid; ?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
        <!-- indicators -->
        <div class="carousel-indicators">
          <?php foreach ($slides as $i => $_): ?>
            <button type="button" data-bs-target="#<?php echo $cid; ?>" data-bs-slide-to="<?php echo $i; ?>"
                    class="<?php echo $i===0?'active':''; ?>" aria-label="Slide <?php echo $i+1; ?>"
                    <?php if($i===0) echo 'aria-current="true"'; ?>></button>
          <?php endforeach; ?>
        </div>

        <!-- slides -->
        <div class="carousel-inner">
          <?php foreach ($slides as $i => $group): ?>
            <div class="carousel-item <?php echo $i===0?'active':''; ?>">
              <div class="row g-4 justify-content-center">
                <?php foreach ($group as $html): ?>
                  <div class="col-md-4"><?php echo $html; ?></div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $cid; ?>" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $cid; ?>" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </button>
      </div>
    <?php endif; ?>
  </div>
</section>



<?php get_footer(); ?>