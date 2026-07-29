<?php
/**
 * Block: Home Hero
 *
 * ACF block render template for the hero section.
 * Uses option fields for heading, tagline, and visual.
 *
 * Fields expected on options page:
 * - hero_heading (text)
 * - hero_tagline (textarea)
 * - hero_visual_image (image)
 */

$heading   = ( function_exists( 'get_field' ) ? get_field( 'hero_heading', 'option' ) : '' ) ?: 'PRESERVING THE HEARTBEAT OF THE KATHMANDU VALLEY';
$tagline   = ( function_exists( 'get_field' ) ? get_field( 'hero_tagline', 'option' ) : '' ) ?: 'Celebrating Centuries of Culture, Agriculture, and Community';
$visual    = ( function_exists( 'get_field' ) ? get_field( 'hero_visual_image', 'option' ) : '' );
?>
<section class="hero" aria-labelledby="hero-heading">
    <div class="hero__container">
        <div class="hero__content">
            <h1 id="hero-heading" class="hero__heading-main">
                <?php echo esc_html( $heading ); ?>
            </h1>
            <p class="hero__tagline">
                <?php echo esc_html( $tagline ); ?>
            </p>
            <div class="hero__underline" aria-hidden="true"></div>
            <div class="hero__scroll-indicator" aria-hidden="true">
                <span><?php esc_html_e( 'Scroll', 'newar-heritage' ); ?></span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 13l5 5 5-5M7 6l5 5 5-5"/></svg>
            </div>
        </div>

        <div class="hero__visual">
            <div class="hero__visual-placeholder">
                <span class="hero__dev-text hero__dev-text--1">कथमाडौं ज्यापु समाज</span>
                <span class="hero__dev-text hero__dev-text--2">Newar Heritage</span>
                <?php if ( $visual && is_array( $visual ) && ! empty( $visual['url'] ) ) : ?>
                    <img src="<?php echo esc_url( $visual['url'] ); ?>" alt="<?php echo esc_attr( $heading ); ?>" style="max-width: 100%; height: auto; border-radius: var(--radius-md); margin-top: var(--space-md);" />
                <?php else : ?>
                    <span class="screen-reader-text"><?php esc_html_e( 'Heritage Artwork', 'newar-heritage' ); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
