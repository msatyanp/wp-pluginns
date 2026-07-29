<?php
/**
 * Component: Heritage Cards Section
 *
 * @param array $args
 * @param array $args['data'] Cards data array.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'data' => array(),
    )
);

$data    = $args['data'];
$heading = ! empty( $data['headingCustomizer'] ) ? get_theme_mod( $data['headingCustomizer'], $data['headingDefault'] ?? '' ) : ( $data['headingDefault'] ?? '' );
$items   = ! empty( $data['items'] ) ? $data['items'] : array();
?>

<section class="cards-section" aria-labelledby="cards-heading">
    <div class="site-container">
        <?php if ( $heading ) : ?>
            <h2 id="cards-heading" class="cards-section__heading">
                <?php echo esc_html( $heading ); ?>
            </h2>
        <?php endif; ?>

        <?php if ( ! empty( $items ) ) : ?>
            <div class="cards-section__grid">
                <?php foreach ( $items as $item ) :
                    $title = ! empty( $item['title'] ) ? $item['title'] : '';
                    $desc  = ! empty( $item['description'] ) ? $item['description'] : '';
                    $link  = ! empty( $item['link'] ) ? $item['link'] : '#';
                    ?>
                    <article class="heritage-card">
                        <?php if ( $title ) : ?>
                            <h3 class="heritage-card__title"><?php echo esc_html( $title ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $desc ) : ?>
                            <p class="heritage-card__body"><?php echo esc_html( $desc ); ?></p>
                        <?php endif; ?>
                        <?php if ( $link ) : ?>
                            <a href="<?php echo esc_url( $link ); ?>" class="heritage-card__link"><?php esc_html_e( 'Learn More', 'newar-heritage' ); ?></a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
