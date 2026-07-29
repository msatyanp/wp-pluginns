<?php
/**
 * Fallback Index Template
 *
 * Acts as a catch-all for any queries that don't match
 * a more specific template. Shows a grid of the latest posts.
 */

get_header();
?>

<section class="section" aria-labelledby="blog-heading">
    <div class="site-container">
        <h2 id="blog-heading"><?php esc_html_e( 'Latest Updates', 'newar-heritage' ); ?></h2>

        <div class="blog-layout">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn">
                            <?php esc_html_e( 'Read More', 'newar-heritage' ); ?>
                        </a>
                    </article>
                    <?php
                endwhile;

                the_posts_pagination( array(
                    'prev_text' => __( '&larr; Previous', 'newar-heritage' ),
                    'next_text' => __( 'Next &rarr;', 'newar-heritage' ),
                ) );
            else :
                ?>
                <p><?php esc_html_e( 'No posts found.', 'newar-heritage' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();
