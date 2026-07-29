<?php
/**
 * Single Post Template
 *
 * Used for individual blog posts.
 */

get_header();
?>

<section class="section section--white" aria-labelledby="post-title">
    <div class="site-container">
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-layout' ); ?>>
            <header class="post-header" style="text-align: center; margin-bottom: var(--space-xl); padding-bottom: var(--space-lg); border-bottom: 3px solid var(--color-gold);">
                <h1 id="post-title" style="font-family: var(--font-heading); font-size: clamp(2rem, 5vw, 2.75rem); color: var(--color-chocolate-cosmos); margin: 0;"><?php the_title(); ?></h1>
                <div class="post-meta" style="margin-top: var(--space-sm); font-size: 0.9rem; color: var(--color-smoky-black); opacity: 0.8;">
                    <?php esc_html_e( 'By', 'newar-heritage' ); ?> <?php the_author(); ?> &bull; <?php echo esc_html( get_the_date() ); ?>
                </div>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail" style="margin-bottom: var(--space-xl); text-align: center;">
                    <?php the_post_thumbnail( 'large', array( 'style' => 'max-width: 100%; height: auto; border-radius: var(--radius-md); border: 1px solid var(--color-border-grey);' ) ); ?>
                </div>
            <?php endif; ?>

            <div class="post-content" style="font-size: 1rem; line-height: 1.8; color: var(--color-smoky-black);">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'newar-heritage' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </article>
    </div>
</section>

<?php
get_footer();
