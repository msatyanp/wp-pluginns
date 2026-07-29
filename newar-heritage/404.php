<?php
/**
 * 404 Error Template
 */

get_header();
?>

<section class="section section--white" aria-labelledby="error-heading">
    <div class="site-container" style="text-align: center; padding: var(--space-3xl) var(--space-md);">
        <h1 id="error-heading" style="font-size: clamp(3rem, 8vw, 6rem); color: var(--color-chocolate-cosmos); margin-bottom: var(--space-md);">404</h1>
        <h2 style="font-size: clamp(1.5rem, 4vw, 2rem); color: var(--color-chocolate-cosmos); margin-bottom: var(--space-lg);">
            <?php esc_html_e( 'Page Not Found', 'newar-heritage' ); ?>
        </h2>
        <p style="font-size: 1.1rem; color: var(--color-smoky-black); margin-bottom: var(--space-xl); max-width: 600px; margin-left: auto; margin-right: auto;">
            <?php esc_html_e( 'Sorry, the page you are looking for could not be found. It may have been moved, deleted, or you entered the wrong URL.', 'newar-heritage' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn" style="display: inline-block; padding: var(--space-sm) var(--space-xl); background-color: var(--color-chocolate-cosmos); color: var(--color-white); font-family: var(--font-heading); font-size: 1rem; font-weight: 600; border-radius: var(--radius-sm); text-decoration: none; border: none; cursor: pointer; transition: background-color var(--transition-fast), transform var(--transition-fast);">
            <?php esc_html_e( 'Return to Home', 'newar-heritage' ); ?>
        </a>
    </div>
</section>

<?php
get_footer();
