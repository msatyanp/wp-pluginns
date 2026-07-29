<?php
/**
 * Block: Gallery Section
 *
 * ACF block render template for gallery grid.
 *
 * Fields expected on options page:
 * - gallery_heading (text)
 * - heritage_gallery (gallery)
 */

$heading  = ( function_exists( 'get_field' ) ? get_field( 'gallery_heading', 'option' ) : '' ) ?: 'Canvas of Our Heritage';
$gallery  = ( function_exists( 'get_field' ) ? get_field( 'heritage_gallery', 'option' ) : '' );
?>
<section class="gallery-section" aria-labelledby="gallery-heading">
    <div class="site-container">
        <h2 id="gallery-heading">
            <?php echo esc_html( $heading ); ?>
        </h2>

        <div class="gallery-grid">
            <?php if ( $gallery && is_array( $gallery ) ) : ?>
                <?php foreach ( $gallery as $image ) : ?>
                    <div class="gallery-grid__item">
                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" loading="lazy" />
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <?php for ( $i = 0; $i < 8; $i++ ) : ?>
                    <div class="gallery-grid__item">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/patterns/placeholder-photo.svg' ); ?>" alt="<?php esc_attr_e( 'Heritage photo placeholder', 'newar-heritage' ); ?>" loading="lazy" />
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
