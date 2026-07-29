<?php
/**
 * Archive Template
 *
 * Used for category, tag, date, and author archive pages.
 */

get_header();
?>

<section class="section section--white" aria-labelledby="archive-title">
    <div class="site-container">
        <?php if ( have_posts() ) : ?>
            <header class="archive-header" style="text-align: center; margin-bottom: var(--space-xl); padding-bottom: var(--space-lg); border-bottom: 3px solid var(--color-gold);">
                <h1 id="archive-title" style="font-family: var(--font-heading); font-size: clamp(2rem, 5vw, 2.75rem); color: var(--color-chocolate-cosmos); margin: 0;">
                    <?php
                    if ( is_category() ) :
                        single_cat_title();
                    elseif ( is_tag() ) :
                        single_tag_title();
                    elseif ( is_author() ) :
                        printf( esc_html__( 'Posts by %s', 'newar-heritage' ), get_the_author() );
                    elseif ( is_date() ) :
                        if ( is_month() ) :
                            printf( esc_html__( 'Posts from %s', 'newar-heritage' ), get_the_date( 'F Y' ) );
                        elseif ( is_year() ) :
                            printf( esc_html__( 'Posts from %s', 'newar-heritage' ), get_the_date( 'Y' ) );
                        else :
                            esc_html_e( 'Daily Archives', 'newar-heritage' );
                        endif;
                    else :
                        esc_html_e( 'Archives', 'newar-heritage' );
                    endif;
                    ?>
                </h1>
                <?php if ( category_description() ) : ?>
                    <p style="margin-top: var(--space-sm); color: var(--color-smoky-black); opacity: 0.9;"><?php echo category_description(); ?></p>
                <?php endif; ?>
            </header>

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

                <?php
                the_posts_pagination( array(
                    'prev_text' => __( '&larr; Previous', 'newar-heritage' ),
                    'next_text' => __( 'Next &rarr;', 'newar-heritage' ),
                ) );
                ?>
            </div>
        <?php else : ?>
            <p style="text-align: center; padding: var(--space-xl);"><?php esc_html_e( 'No posts found.', 'newar-heritage' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
