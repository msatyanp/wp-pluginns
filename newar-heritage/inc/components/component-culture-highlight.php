<?php
/**
 * Component: Culture Highlight
 *
 * @param array $args
 * @param array $args['data'] Culture data array.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'data' => array(),
    )
);

$data = $args['data'];

if ( empty( $data ) ) {
    return;
}

$title        = ! empty( $data['titleCustomizer'] ) ? get_theme_mod( $data['titleCustomizer'], $data['titleEn'] ?? '' ) : ( $data['titleEn'] ?? '' );
$subtitle     = ! empty( $data['subtitleCustomizer'] ) ? get_theme_mod( $data['subtitleCustomizer'], $data['titleNe'] ?? '' ) : ( $data['titleNe'] ?? '' );
$tags         = ! empty( $data['tags'] ) ? $data['tags'] : array();
$body         = ! empty( $data['bodyEn'] ) ? $data['bodyEn'] : '';
$tabs         = ! empty( $data['tabs'] ) ? $data['tabs'] : array();
?>

<section class="culture-highlight" aria-labelledby="culture-title">
    <div class="site-container">
        <div class="culture-highlight__header">
            <h2 id="culture-title" class="culture-highlight__title">
                <?php echo esc_html( $title ); ?>
            </h2>
            <?php if ( $subtitle ) : ?>
                <p class="culture-highlight__subtitle">
                    <?php echo esc_html( $subtitle ); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $tags ) ) : ?>
            <div class="culture-highlight__tags">
                <?php foreach ( $tags as $tag ) : ?>
                    <span class="culture-pill"><?php echo esc_html( $tag ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( $body ) : ?>
            <p class="culture-highlight__body">
                <?php echo esc_html( $body ); ?>
            </p>
        <?php endif; ?>

        <?php if ( ! empty( $tabs ) ) : ?>
            <div class="culture-highlight__tabs">
                <?php foreach ( $tabs as $tab ) : ?>
                    <a href="#<?php echo esc_attr( $tab['id'] ?? '#' ); ?>" class="culture-tab">
                        <span class="culture-tab__icon">
                            <?php echo wp_kses_post( $tab['icon'] ?? '' ); ?>
                        </span>
                        <span class="culture-tab__label"><?php echo esc_html( $tab['label'] ?? '' ); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
