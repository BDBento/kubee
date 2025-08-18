<section class="planos-home py-5">
    <div class="container">
        <div class="section-header">
            <h2>Confira nossos planos</h2>

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
                        <div class="plano-card h-100" data-preco-mensal="<?php echo esc_attr($pm); ?>"
                            data-preco-anual="<?php echo esc_attr($pa); ?>">
                            <h3 class="plano-title"><?php the_title(); ?></h3>
                            <div class="plano-sub"><?php the_excerpt() ?></div>
                            <ul class="plano-list">
                                <?php foreach ($rec as $r): ?>
                                    <li><i class="bi bi-check2"></i> <?php echo esc_html($r); ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <?php if ($cta_url): ?>
                                <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-primary w-100 mb-2">
                                    <?php echo esc_html($cta_txt ?: 'Assinar plano'); ?>
                                </a>
                            <?php endif; ?>

                            <div class="plano-preco">
                                R$ <span class="pl-preco"><?php echo esc_html($pm !== '' ? $pm : '0'); ?></span>/<span
                                    class="pl-periodo">mês</span>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
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
            setTimeout(() => card.classList.remove('is-changing'), 200); // combina com .22s
        }

        function apply(period) {
            cards.forEach(card => {
                const val = period === 'anual' ? (card.dataset.precoAnual || '0') : (card.dataset.precoMensal || '0');
                swapPrice(card, val, period === 'anual' ? 'ano' : 'mês');
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