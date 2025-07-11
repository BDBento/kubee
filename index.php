<?php get_header(); ?>

<main class="container py-5">
    <?php if ( have_posts() ) : ?>
        <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-md-8 mx-auto mb-4">
                    <article <?php post_class('card shadow-sm p-4'); ?>>
                        <h2 class="h4 mb-3"><a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a></h2>
                        <div class="mb-2 small text-muted"><?php the_date(); ?> | <?php the_author(); ?></div>
                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-4">
            <?php the_posts_pagination([
                'prev_text' => __('« Anterior', 'kubee'),
                'next_text' => __('Próximo »', 'kubee'),
            ]); ?>
        </div>
    <?php else : ?>
        <div class="alert alert-warning">Nenhum post encontrado.</div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>