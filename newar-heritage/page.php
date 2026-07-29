<?php
/**
 * Default Page Template
 *
 * Used for standard WordPress pages.
 */

get_header();
?>

<section class="section section--white" aria-labelledby="page-title" style="background-color: #ffffff; padding: var(--space-3xl) var(--space-md);">
    <div class="site-container">
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'page-layout' ); ?> style="max-width: 800px; margin: 0 auto; padding: var(--space-xl); background: #ffffff; border-radius: var(--radius-lg);">
            <header class="page-header" style="text-align: center; margin-bottom: var(--space-xl); padding-bottom: var(--space-lg); border-bottom: 3px solid var(--color-gold);">
                <h1 id="page-title" style="font-family: var(--font-heading); font-size: clamp(2rem, 5vw, 2.75rem); color: var(--color-chocolate-cosmos); margin: 0; position: relative; display: inline-block;"><?php the_title(); ?></h1>
            </header>

            <div class="page-content" style="font-size: 1rem; line-height: 1.8; color: var(--color-smoky-black);">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . __( 'Pages:', 'newar-heritage' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </article>
    </div>
</section>

<?php
if ( comments_open() || get_comments_number() ) :
    comments_template();
endif;
?>

<?php
get_footer();
