<section class="planos-home py-5" id="planos">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Confira nossos planos</h2>
            <p class="section-subtitle">Escolha o plano ideal para sua empresa e comece a transformar sua comunicação hoje mesmo!</p>
            <hr>
            <div class="planos-precos">
                <span class="pl-preco">Desconto de exclusivos para planos Anuais</span>
            </div>

            <!-- Toggle Mensal/Anual -->
            <div class="planos-toggle" role="group" aria-label="Periodicidade">
                <input type="radio" class="btn-check" name="pl-toggle" id="pl-mensal" autocomplete="off" checked>
                <label class="btn btn-toggle" for="pl-mensal" aria-pressed="true">Mensal</label>

                <input type="radio" class="btn-check" name="pl-toggle" id="pl-anual" autocomplete="off">
                <label class="btn btn-toggle" for="pl-anual" aria-pressed="false">Anual</label>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <?php
            $qp = new WP_Query([
                'post_type' => 'planos',
                'posts_per_page' => -1,
                'orderby' => 'menu_order title',
                'order' => 'ASC'
            ]);

            if ($qp->have_posts()):
                while ($qp->have_posts()):
                    $qp->the_post();
                    $pm = trim((string) get_post_meta(get_the_ID(), '_pl_preco_mensal', true));
                    $pa = trim((string) get_post_meta(get_the_ID(), '_pl_preco_anual', true));
                    $cta_txt = get_post_meta(get_the_ID(), '_pl_cta_txt', true);
                    $cta_url = get_post_meta(get_the_ID(), '_pl_cta_url', true);
                    $rec_txt = (string) get_post_meta(get_the_ID(), '_pl_recursos', true);
                    $rec = array_filter(array_map('trim', explode("\n", $rec_txt)));
                    ?>
                    <div class="col-md-3">
                        <div class="plano-card h-100 d-flex flex-column" data-preco-mensal="<?php echo esc_attr($pm); ?>"
                            data-preco-anual="<?php echo esc_attr($pa); ?>">

                            <h3 class="plano-title"><?php the_title(); ?></h3>
                            <div class="plano-sub"><?php the_excerpt(); ?></div>
                            <ul class="plano-list">
                                <?php foreach ($rec as $r): ?>
                                    <li><i class="bi bi-check2"></i> <?php echo esc_html($r); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="plano-foot mt-auto">
                                <?php if ($cta_url): ?>
                                    <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary w-100 mb-2">
                                        <?php echo esc_html($cta_txt ?: 'Assinar plano'); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="plano-preco">
                                    A partir de R$ <span class="pl-preco"><?php echo esc_html($pm !== '' ? $pm : '0'); ?></span>/<span
                                        class="pl-periodo">Mês</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
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
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const radios = document.querySelectorAll('input[name="pl-toggle"]');
        const labels = {
            mensal: document.querySelector('label[for="pl-mensal"]'),
            anual: document.querySelector('label[for="pl-anual"]')
        };
        const cards = document.querySelectorAll('.plano-card');

        function swapPrice(card, value, period) {
            const priceEl = card.querySelector('.pl-preco');
            const perEl = card.querySelector('.pl-periodo');
            if (!priceEl || !perEl) return;

            card.classList.add('is-changing');
            priceEl.classList.remove('price-swap'); void priceEl.offsetWidth;
            perEl.classList.remove('price-swap'); void perEl.offsetWidth;

            priceEl.textContent = value || '0';
            perEl.textContent = period;

            priceEl.classList.add('price-swap');
            perEl.classList.add('price-swap');
            setTimeout(() => card.classList.remove('is-changing'), 200);
        }

        function apply(period) {
            cards.forEach(card => {
                const val = period === 'anual' ? (card.dataset.precoAnual || '0') : (card.dataset.precoMensal || '0');
                swapPrice(card, val, period === 'anual' ? 'Ano' : 'Mês');
            });
            labels.mensal.classList.toggle('active', period === 'mensal');
            labels.anual.classList.toggle('active', period === 'anual');
            labels.mensal.setAttribute('aria-pressed', period === 'mensal');
            labels.anual.setAttribute('aria-pressed', period === 'anual');
        }

        radios.forEach(r => r.addEventListener('change', () => {
            apply(document.getElementById('pl-anual').checked ? 'anual' : 'mensal');
        }));

        apply(document.getElementById('pl-anual').checked ? 'anual' : 'mensal');
    });
</script>