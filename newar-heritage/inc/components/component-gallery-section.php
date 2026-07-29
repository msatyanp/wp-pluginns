<?php
/**
 * Component: Gallery Section
 *
 * @param array $args
 * @param array  $args['data']            Gallery section data.
 * @param string $args['heading_mod']     Customizer setting for heading.
 * @param string $args['customizer_prefix'] Customizer prefix for gallery images.
 * @param int    $args['placeholder_count'] Number of placeholders when empty.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'data'                => array(),
        'heading_mod'         => 'newar_heritage_gallery_heading',
        'customizer_prefix'   => 'newar_heritage_gallery_image_',
        'placeholder_count'   => 8,
    )
);

$data         = $args['data'];
$heading      = ! empty( $data['headingCustomizer'] ) ? get_theme_mod( $data['headingCustomizer'], $data['headingDefault'] ?? '' ) : ( $data['headingDefault'] ?? '' );
$images       = ! empty( $data['images'] ) ? $data['images'] : array();
$prefix       = $args['customizer_prefix'];
$placeholders = (int) $args['placeholder_count'];

if ( function_exists( 'get_field' ) ) {
    $acf_images = get_field( 'heritage_gallery', 'option' );
    if ( ! empty( $acf_images ) ) {
        $images = $acf_images;
    }
}

if ( empty( $images ) ) {
    for ( $i = 1; $i <= $placeholders; $i++ ) {
        $image_id = get_theme_mod( $prefix . $i, '' );
        if ( ! $image_id ) {
            continue;
        }
        $url      = wp_get_attachment_image_url( $image_id, 'large' );
        $alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
        if ( ! $alt ) {
            $alt = $heading ? $heading : __( 'Heritage photo placeholder', 'newar-heritage' );
        }
        if ( ! $url ) {
            continue;
        }
        $images[] = array(
            'src' => $url,
            'alt' => $alt,
        );
    }
}

if ( empty( $images ) ) {
    for ( $i = 0; $i < $placeholders; $i++ ) {
        $images[] = array(
            'src' => get_stylesheet_directory_uri() . '/assets/patterns/placeholder-photo.svg',
            'alt' => __( 'Heritage photo placeholder', 'newar-heritage' ),
        );
    }
}

if ( ! $heading ) {
    $heading = __( 'Canvas of Our Heritage', 'newar-heritage' );
}
?>

<section class="gallery-section" aria-labelledby="gallery-heading">
    <div class="site-container">
        <h2 id="gallery-heading" class="gallery-section__heading">
            <?php echo esc_html( $heading ); ?>
        </h2>

        <div class="gallery-section__grid">
            <?php foreach ( $images as $image ) :
                $src = ! empty( $image['src'] ) ? $image['src'] : ( ! empty( $image['url'] ) ? $image['url'] : '' );
                $alt = ! empty( $image['alt'] ) ? $image['alt'] : ( ! empty( $image['title'] ) ? $image['title'] : $heading );
                if ( ! $src ) {
                    continue;
                }
                ?>
                <div class="gallery-card">
                    <<?php echo ! empty( $image['is_customizer_image'] ) ? 'div' : 'div'; ?> class="gallery-card__inner">
                        <img src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="gallery-card__image" loading="lazy" />
                    </<?php echo ! empty( $image['is_customizer_image'] ) ? 'div' : 'div'; ?>>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
