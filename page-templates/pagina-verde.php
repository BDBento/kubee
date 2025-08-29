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
