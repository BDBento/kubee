<section class="planos-home py-5" id="planos">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="section-title">Escolha o seu plano</h2>
      <p class="section-subtitle">Conheça nossos planos e escolha a solução ideal para a sua empresa. Transforme sua comunicação com eficiência e inovação!</p>

      <div class="planos-toggle mt-3" role="tablist" aria-label="Alternar tipo">
        <button class="btn btn-outline-primary active" data-plan="operacao" aria-selected="true">CRM Inteligente</button>
        <button class="btn btn-outline-primary" data-plan="infraestrutura" aria-selected="false">Tecnologia e </br>Infraestrutura</button>
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
          $ops       = kubee_plano_recursos($pid, 'operacao');
          $infs      = kubee_plano_recursos($pid, 'infraestrutura');
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
      'post_type'      => 'ferramentas_usadas',
      'posts_per_page' => 50,
      'orderby'        => 'menu_order',
      'order'          => 'ASC',
      'no_found_rows'  => true,
      'post_status'    => 'publish',
    ]);
    ?>

    <div class="kubee-ferramentas-wrap container" role="region" aria-label="Ferramentas usadas">
      <div class="kubee-ferramentas-title dep-title">
        <h3><span>Nossas Ferramentas</span></h3>
        <p class="dep-sub">Utilizamos as melhores tecnologias do mercado para entregar soluções ágeis, eficientes e que fazem a diferença no dia a dia da sua empresa.</p>
      </div>

      <div class="kubee-ferramentas" tabindex="0">
        <?php if ($qf->have_posts()):
          while ($qf->have_posts()):
            $qf->the_post();
            $url   = get_post_meta(get_the_ID(), '_kubee_ferramenta_url', true);
            $title = get_the_title();
            $thumb_url = function_exists('kubee_ferramenta_icon_url') ? kubee_ferramenta_icon_url(get_the_ID()) : '';
            ?>
            <div class="kubee-ferramenta-item">
              <a <?php echo $url ? 'href="' . esc_url($url) . '" target="_blank" rel="noopener"' : ''; ?>
                 aria-label="<?php echo esc_attr($title); ?>">
                <?php if ($thumb_url): ?>
                  <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" decoding="async">
                <?php else: ?>
                  <svg width="72" height="72" viewBox="0 0 72 72" role="img" aria-label="sem ícone" style="display:block;margin:0 auto 6px;">
                    <rect width="72" height="72" fill="#f0f0f0" />
                    <text x="50%" y="50%" text-anchor="middle" dominant-baseline="middle" font-size="10" fill="#777">sem ícone</text>
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

    <!-- JS único do carrossel de ferramentas: loop infinito e passo suave -->
<script>
  (function(){
    const wrap  = document.querySelector('.kubee-ferramentas-wrap');
    if(!wrap) return;
    const track = wrap.querySelector('.kubee-ferramentas');
    const MAX_VIS = 7;              // 7 visíveis
    const STEP_MS = 2000;           // pausa entre passos (mais lento)
    const DURATION = 2000;          // duração da animação em ms (mais suave)

    // Clona itens para loop infinito
    const original = Array.from(track.children);
    const origLen = original.length;
    if(origLen === 0) return;

    if(origLen > MAX_VIS){
      for(let i=0;i<MAX_VIS;i++){
        const clone = original[i].cloneNode(true);
        clone.setAttribute('aria-hidden','true');
        track.appendChild(clone);
      }
    }

    const items = Array.from(track.children);
    let index = 0;
    let playing = false;
    let stoppedByUser = false;
    let rafId = null;
    let stepTimer = null;

    function getX(i){
      const baseLeft = items[0].offsetLeft;
      return items[i].offsetLeft - baseLeft;
    }

    function animateTo(xTarget, duration){
      cancelAnimationFrame(rafId);
      const start = track.scrollLeft;
      const dist = xTarget - start;
      if(Math.abs(dist) < 1){ track.scrollLeft = xTarget; return Promise.resolve(); }

      return new Promise(resolve=>{
        const t0 = performance.now();
        const ease = t=>{
          // easeInOutCubic
          return t < 0.5 ? 4*t*t*t : 1 - Math.pow(-2*t+2,3)/2;
        };
        const tick = (now)=>{
          const p = Math.min(1, (now - t0)/duration);
          track.scrollLeft = start + dist * ease(p);
          if(p < 1){ rafId = requestAnimationFrame(tick); }
          else { resolve(); }
        };
        rafId = requestAnimationFrame(tick);
      });
    }

    async function goTo(i, smooth=true){
      index = i;
      if(origLen > MAX_VIS && index > origLen){
        index = origLen;
        await animateTo(getX(index), smooth ? DURATION : 0);
        track.scrollLeft = getX(0);
        index = 1;
        return;
      }
      if(index < 0 && origLen > MAX_VIS){
        track.scrollLeft = getX(origLen);
        index = origLen - 1;
      }
      await animateTo(getX(index), smooth ? DURATION : 0);
    }

    function scheduleNext(){
      if(stoppedByUser || playing) return;
      stepTimer = setTimeout(async ()=>{
        if(stoppedByUser) return;
        playing = true;
        await goTo(index + 1, true);
        playing = false;
        scheduleNext();
      }, STEP_MS);
    }

    function stopAuto(){
      stoppedByUser = true;
      playing = false;
      clearTimeout(stepTimer);
      cancelAnimationFrame(rafId);
    }
    function startAuto(){
      if(original.length <= MAX_VIS) return;
      stoppedByUser = false;
      scheduleNext();
    }

    // Botões
    wrap.querySelectorAll('.kubee-ferr-btn').forEach(btn=>{
      btn.addEventListener('click', async ()=>{
        stopAuto();
        const dir = parseInt(btn.getAttribute('data-dir'),10) || 1;
        await goTo(index + dir, true);
        startAuto();
      });
    });

    // Pausar em interação
    ['mouseenter','focusin','touchstart','pointerdown'].forEach(evt=>{
      track.addEventListener(evt, stopAuto);
    });
    ['mouseleave','focusout'].forEach(evt=>{
      track.addEventListener(evt, startAuto);
    });

    // Corrigir offsets após resize
    let rAF = null;
    window.addEventListener('resize', ()=>{
      if(rAF) cancelAnimationFrame(rAF);
      rAF = requestAnimationFrame(()=> animateTo(getX(index), 0));
    });

    // Init
    track.scrollLeft = 0;
    goTo(0, false).then(startAuto);
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

    /* ---- Ferramentas: 7 itens visíveis, rolagem suave ---- */
    .kubee-ferramentas{
      display:flex;
      gap:16px;
      overflow:hidden;            /* oculta excedente */
      align-items:center;
      /* sem scroll-behavior aqui. animação é controlada no JS para suavidade */
    }
    .kubee-ferramenta-item{
      flex:0 0 calc((100% - 6*16px)/7); /* 7 por vez */
      text-align:center;
    }
    .kubee-ferramenta-item img{ max-height:56px; width:auto; display:inline-block; }

    /* Responsivo: 5 / 3 itens */
    @media (max-width:992px){
      .kubee-ferramenta-item{ flex:0 0 calc((100% - 4*16px)/5); }
    }
    @media (max-width:576px){
      .kubee-ferramenta-item{ flex:0 0 calc((100% - 2*16px)/3); }
    }
  </style>
</section>

<!-- Toggle Operacionais x Estruturais (mantido) -->
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
