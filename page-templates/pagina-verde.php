<?php
/**
 * Template Name: Página Verde
 * Template Post Type: page
 */
get_header();
?>
<style>
    :root {
        --verde-fundo: #E6F7F2;
    }

    /* ajuste o tom aqui */
    .pagina-verde {
       background: linear-gradient(90deg, #c2fcfa, #ffffff, #c2fcfa);
        min-height: 100vh;
    }

    .pagina-verde .wrap {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 16px;
    }
</style>

<main class="pagina-verde">
    <div class="wrap">
        <?php while (have_posts()):
            the_post();
            the_content(); endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>








<section class="guia-rapido">
    <ol class="gr-steps">
        <li class="span-full">
            <h3>Escolha um plano</h3>
            <p>Selecione um plano que mais se adequa às suas necessidades hoje.</p>
        </li>
        <li class="span-full">
            <h3>licença ativada</h3>
            <p>efetive a compra do plano e tenha sua licença ativada.</p>
        </li>
        <li class="span-full">
            <h3>Acesse todos benefícios</h3>
            <p>Acesse todos recursos de onde quiser e quando quiser.</p>
        </li>
    </ol>
</section>

<style>
    .guia-rapido {
        background: #E6F7F2;
        padding: 24px;
        border-radius: 12px;
        max-width: 900px
    }

    /* grade externa: 2 colunas; 3º item ocupa as duas */
    .gr-steps {
        list-style: none;
        margin: 0;
        padding: 0;
        counter-reset: gr;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px 32px;
    }

    .gr-steps .span-full {
        grid-column: 1 / -1
    }

    /* item: selo na col 1; h3+p sempre na col 2 */
    .gr-steps li {
        counter-increment: gr;
        display: grid;
        grid-template-columns: 40px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
    }

    .gr-steps li::before {
        content: counter(gr);
        grid-column: 1;
        display: grid;
        place-items: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #10a37f;
        color: #fff;
        font-weight: 700;
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .gr-steps li h3 {
        grid-column: 2;
        margin: 0;
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1.2;
        color: #1d2939
    }

    .gr-steps li p {
        grid-column: 2;
        margin: 4px 0 0;
        font-size: 1.5rem;
        line-height: 1.5;
        color: #344054
    }

    /* mobile */
    @media (max-width:680px) {
        .gr-steps {
            grid-template-columns: 1fr
        }

        .gr-steps .span-full {
            grid-column: auto
        }
    }
</style>