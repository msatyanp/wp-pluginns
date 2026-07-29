<?php
/**
 * Component: Hero Slider
 *
 * @param array $args
 * @param array  $args['slides']         Array of hero slide data.
 * @param string $args['heading_mod']    Customizer setting for heading.
 * @param string $args['tagline_mod']    Customizer setting for tagline.
 * @param string $args['image_mod']      Customizer setting for hero image ID.
 *
 * Slide shape:
 *   { id, image, headingEn, headingNe, subtext, ctaText, ctaLink }
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'slides'         => array(),
        'heading_mod'    => 'newar_heritage_hero_heading',
        'tagline_mod'    => 'newar_heritage_hero_tagline',
        'image_mod'      => 'newar_heritage_hero_image',
    )
);

$heading  = get_theme_mod( $args['heading_mod'], '' );
$tagline  = get_theme_mod( $args['tagline_mod'], '' );
$hero_id  = get_theme_mod( $args['image_mod'], '' );
$has_slide = false;

if ( ! $heading && ! empty( $args['slides'][0]['headingEn'] ) ) {
    $heading = $args['slides'][0]['headingEn'];
}

if ( ! $tagline && ! empty( $args['slides'][0]['subtext'] ) ) {
    $tagline = $args['slides'][0]['subtext'];
}
?>

<section class="hero" aria-labelledby="hero-heading">
    <div class="hero__container">
        <div class="hero__content">
            <h1 id="hero-heading" class="hero__heading-main">
                <?php echo esc_html( $heading ); ?>
            </h1>
            <?php if ( $tagline ) : ?>
                <p class="hero__tagline">
                    <?php echo esc_html( $tagline ); ?>
                </p>
            <?php endif; ?>
            <div class="hero__underline" aria-hidden="true"></div>
            <div class="hero__scroll-indicator" aria-hidden="true">
                <span><?php esc_html_e( 'Scroll', 'newar-heritage' ); ?></span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 13l5 5 5-5M7 6l5 5 5-5"/></svg>
            </div>
        </div>

        <div class="hero__visual">
            <?php
            if ( $hero_id ) :
                $hero_image = wp_get_attachment_image( $hero_id, 'large', false, array( 'class' => 'hero__image', 'alt' => get_bloginfo( 'name' ) ) );
                if ( $hero_image ) :
                    echo $hero_image;
                    $has_slide = true;
                endif;
            endif;

            if ( ! $has_slide ) :
                foreach ( $args['slides'] as $slide ) :
                    if ( ! empty( $slide['image'] ) && ! $has_slide ) :
                        $img = wp_get_attachment_image( $slide['image'], 'large', false, array( 'class' => 'hero__image', 'alt' => get_bloginfo( 'name' ) ) );
                        if ( $img ) :
                            echo $img;
                            $has_slide = true;
                        endif;
                    endif;
                endforeach;
            endif;

            if ( ! $has_slide ) :
                ?>
                <div class="hero__visual-placeholder">
                    <span class="hero__dev-text hero__dev-text--1">कथमाडौं ज्यापु समाज</span>
                    <span class="hero__dev-text hero__dev-text--2">Newar Heritage</span>
                    <?php esc_html_e( 'Heritage Artwork', 'newar-heritage' ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
