<?php
/**
 * Search Results Template
 */

get_header();
?>

<section class="section section--white" aria-labelledby="search-heading">
    <div class="site-container">
        <header class="page-header" style="margin-bottom: var(--space-xl); padding-bottom: var(--space-lg); border-bottom: 3px solid var(--color-gold);">
            <h1 id="search-heading">
                <?php
                printf(
                    esc_html__( 'Search Results for: %s', 'newar-heritage' ),
                    '<span class="search-query">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="blog-layout">
                <?php
                while ( have_posts() ) :
                    the_post();
                ?>
                    <article <?php post_class(); ?> style="padding: var(--space-lg); margin-bottom: var(--space-lg); border-bottom: 1px solid var(--color-border-grey);">
                        <h2><a href="<?php the_permalink(); ?>" style="color: var(--color-chocolate-cosmos); text-decoration: none;"><?php the_title(); ?></a></h2>
                        <p style="color: var(--color-smoky-black); opacity: 0.9;"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn" style="display: inline-block; padding: var(--space-sm) var(--space-xl); background-color: var(--color-chocolate-cosmos); color: var(--color-white); font-family: var(--font-heading); font-size: 0.9rem; font-weight: 600; border-radius: var(--radius-sm); text-decoration: none; border: none; cursor: pointer; transition: background-color var(--transition-fast), transform var(--transition-fast);">
                            <?php esc_html_e( 'Read More', 'newar-heritage' ); ?>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php
            the_posts_pagination( array(
                'prev_text' => __( '&larr; Previous', 'newar-heritage' ),
                'next_text' => __( 'Next &rarr;', 'newar-heritage' ),
            ) );
            ?>
        <?php else : ?>
            <p style="text-align: center; padding: var(--space-xl);"><?php esc_html_e( 'No results found. Please try another search.', 'newar-heritage' ); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
