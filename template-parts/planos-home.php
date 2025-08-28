<section class="planos-home py-5">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="section-title">Confira nossos planos </h2>
      <p class="section-subtitle">Escolha o plano ideal para sua empresa e comece a transformar sua comunicação hoje mesmo!</p>

      <div class="planos-toggle mt-3" role="tablist" aria-label="Alternar tipo">
        <button class="btn btn-outline-primary active" data-plan="operacao" aria-selected="true">Operacionais</button>
        <button class="btn btn-outline-primary" data-plan="infraestrutura" aria-selected="false">Estruturais</button>
      </div>
    </div>

    <div class="row g-4 justify-content-center">
      <?php
      $qp = new WP_Query([
        'post_type'      => 'planos',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'no_found_rows'  => true
      ]);

      if ($qp->have_posts()):
        while ($qp->have_posts()): $qp->the_post();
          $pid       = get_the_ID();
          $precos    = kubee_plano_precos($pid);
          $labelOper = kubee_format_preco_label($precos['operacao']);
          $labelInf  = kubee_format_preco_label($precos['infraestrutura']);
          $ops       = kubee_plano_recursos($pid, 'operacao');        // retorna array de linhas (inclui vazias)
          $infs      = kubee_plano_recursos($pid, 'infraestrutura');  // idem
          $cta_txt   = get_post_meta($pid, '_pl_cta_txt', true) ?: 'Assinar plano';
          $cta_url   = get_post_meta($pid, '_pl_cta_url', true);
          ?>
          <div class="col-md-4">
            <div class="card h-100 plano-card">
              <?php if (has_post_thumbnail()): ?>
                <div class="card-img-top"><?php the_post_thumbnail('large', ['class'=>'img-fluid','loading'=>'lazy','decoding'=>'async']); ?></div>
              <?php endif; ?>

              <div class="card-body d-flex flex-column">
                <h3 class="h5 card-title"><?php the_title(); ?></h3>
                <p class="card-text"><?php echo wp_kses_post(get_the_excerpt()); ?></p>

                <div class="plano-preco my-2">
                  <span class="preco" data-kind="operacao"><?php echo esc_html($labelOper); ?></span>
                  <span class="preco" data-kind="infraestrutura" hidden><?php echo esc_html($labelInf); ?></span>
                </div>

                <?php if (is_array($ops) || is_array($infs)): ?>
                  <ul class="list-unstyled small mb-3 lista-recursos" data-kind="operacao">
                    <?php foreach ((array)$ops as $li): ?>
                      <?php if ($li === ''): ?>
                        <li class="gap" aria-hidden="true"></li>
                      <?php else: ?>
                        <li><span class="li-text"><?php echo esc_html($li); ?></span></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>

                  <ul class="list-unstyled small mb-3 lista-recursos" data-kind="infraestrutura" hidden>
                    <?php foreach ((array)$infs as $li): ?>
                      <?php if ($li === ''): ?>
                        <li class="gap" aria-hidden="true"></li>
                      <?php else: ?>
                        <li><span class="li-text"><?php echo esc_html($li); ?></span></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>

                <div class="mt-auto">
                  <?php if ($cta_url): ?>
                    <a class="btn btn-primary w-100" href="<?php echo esc_url($cta_url); ?>"><?php echo esc_html($cta_txt); ?></a>
                  <?php else: ?>
                    <button class="btn btn-primary w-100" type="button" disabled><?php echo esc_html($cta_txt); ?></button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php
        endwhile; wp_reset_postdata();
      else:
        echo '<p class="text-center">Nenhum plano publicado.</p>';
      endif;
      ?>
    </div>
     <?php
        // Carrossel de ferramentas
        $qf = new WP_Query([
            'post_type' => 'ferramentas_usadas',
            'posts_per_page' => 50,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
            'post_status' => 'publish',
        ]);
        ?>

        <div class="kubee-ferramentas-wrap container" role="region" aria-label="Ferramentas usadas">
            <div class="kubee-ferramentas-title dep-title">
                <h3><span>Ferramentas</span></h3>
                <p class="dep-sub">Tecnologias que utilizamos para entregar o melhor serviço aos nossos clientes</p>
            </div>
            <div class="kubee-ferramentas" tabindex="0">
                <?php if ($qf->have_posts()):
                    while ($qf->have_posts()):
                        $qf->the_post();
                        $url = get_post_meta(get_the_ID(), '_kubee_ferramenta_url', true);
                        $title = get_the_title();
                        // Pega da galeria (metabox). Se vazio, cai na destacada.
                        $thumb_url = function_exists('kubee_ferramenta_icon_url')
                            ? kubee_ferramenta_icon_url(get_the_ID())
                            : '';
                        ?>
                        <div class="kubee-ferramenta-item">
                            <a <?php echo $url ? 'href="' . esc_url($url) . '" target="_blank" rel="noopener"' : ''; ?>
                                aria-label="<?php echo esc_attr($title); ?>">
                                <?php if ($thumb_url): ?>
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>"
                                        loading="lazy" decoding="async">
                                <?php else: ?>
                                    <svg width="72" height="72" viewBox="0 0 72 72" role="img" aria-label="sem ícone"
                                        style="display:block;margin:0 auto 6px;">
                                        <rect width="72" height="72" fill="#f0f0f0" />
                                        <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" font-size="10"
                                            fill="#777">sem ícone</text>
                                    </svg>
                                <?php endif; ?>
                                <span class="kubee-ferramenta-title-2"><?php echo esc_html($title); ?></span>
                            </a>
                        </div>
                    <?php endwhile; else:
                    if (current_user_can('edit_posts')) {
                        echo '<div class="notice notice-info" style="padding:.75rem;border:1px solid #ddd;border-radius:6px;">Nenhuma <strong>Ferramenta usada</strong> publicada.</div>';
                    }
                endif; ?>
            </div>

            <button type="button" class="kubee-ferr-btn prev" aria-label="Anterior" data-dir="-1">‹</button>
            <button type="button" class="kubee-ferr-btn next" aria-label="Próximo" data-dir="1">›</button>
        </div>

        <script>
            (function () {
                var wrap = document.currentScript.previousElementSibling;
                var scroller = wrap.querySelector('.kubee-ferramentas');
                wrap.querySelectorAll('.kubee-ferr-btn').forEach(function (b) {
                    b.addEventListener('click', function () {
                        var dir = parseInt(b.getAttribute('data-dir'), 10) || 1;
                        scroller.scrollBy({ left: dir * (wrap.clientWidth * 0.6), behavior: 'smooth' });
                    });
                });
            })();
        </script>
        <script>
            (function () {
                const wrap = document.currentScript.previousElementSibling;
                const track = wrap.querySelector('.kubee-ferramentas');
                const items = track.children;
                const maxVis = 7;
                if (items.length <= maxVis) return;               // nada para girar

                let idx = 0;                                      // índice do item visível
                const step = () => {
                    idx = (idx + 1) % items.length;
                    const target = items[idx];
                    const offset = target.offsetLeft - track.offsetLeft;
                    track.scrollTo({ left: offset, behavior: 'smooth' });
                };

                const timer = setInterval(step, 1800);            // 1,8 s

                // pausa rotação se usuário interagir
                ['mouseenter', 'focusin', 'touchstart'].forEach(evt => {
                    track.addEventListener(evt, () => clearInterval(timer), { once: true });
                });
            })();
        </script>

        <?php wp_reset_postdata(); ?>
  </div>

  <style>
    /* preservar espaços e quebras nas linhas dos recursos */
    .planos-home .lista-recursos .li-text{ white-space:pre-wrap; }
    /* linha em branco sem ícone */
    .planos-home .lista-recursos li.gap{ padding:0; margin:.35rem 0; min-height:.35rem; list-style:none; }
    .planos-home .lista-recursos li.gap::before,
    .planos-home .lista-recursos li.gap::after{ content:none !important; }
  </style>
</section>

<script>
(function(){
  const buttons = document.querySelectorAll('.planos-toggle button');
  const setPlan = (kind) => {
    buttons.forEach(b => {
      const on = b.getAttribute('data-plan') === kind;
      b.classList.toggle('active', on);
      b.setAttribute('aria-selected', on ? 'true' : 'false');
    });
    document.querySelectorAll('[data-kind]').forEach(el => {
      el.hidden = el.getAttribute('data-kind') !== kind;
    });
  };
  buttons.forEach(b => b.addEventListener('click', () => setPlan(b.getAttribute('data-plan'))));
  setPlan('operacao');
})();
</script>
