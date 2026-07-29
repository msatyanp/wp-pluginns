<?php
/**
 * Component: Stats Section
 *
 * @param array $args
 * @param array $args['data'] Stats data array.
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

$heading = ! empty( $data['headingCustomizer'] ) ? get_theme_mod( $data['headingCustomizer'], $data['headingDefault'] ?? '' ) : ( $data['headingDefault'] ?? '' );
$items   = ! empty( $data['items'] ) ? $data['items'] : array();

if ( empty( $items ) && ! empty( $data['numberDefaults'] ) && ! empty( $data['labelDefaults'] ) ) {
    $items = array();
    foreach ( $data['numberDefaults'] as $index => $number ) {
        $items[] = array(
            'label'  => $data['labelDefaults'][ $index ] ?? '',
            'value'  => $number,
            'suffix' => '',
        );
    }
}

if ( ! $heading && ! empty( $data['headingDefault'] ) ) {
    $heading = $data['headingDefault'];
}
?>

<section class="stats-section stats-section--horizontal" aria-labelledby="stats-heading">
    <div class="site-container">
        <?php if ( $heading ) : ?>
            <<?php echo esc_html( apply_filters( 'newar_heritage_stats_heading_tag', 'h2' ) ); ?>
                id="stats-heading"
                class="stats-section__heading"
            >
                <?php echo esc_html( $heading ); ?>
            </<?php echo esc_html( apply_filters( 'newar_heritage_stats_heading_tag', 'h2' ) ); ?>>
        <?php endif; ?>

        <?php if ( ! empty( $items ) ) : ?>
            <div class="stats-section__grid">
                <?php foreach ( $items as $item ) :
                    $label  = ! empty( $item['label'] ) ? $item['label'] : '';
                    $value  = ! empty( $item['value'] ) ? $item['value'] : '';
                    $suffix = ! empty( $item['suffix'] ) ? $item['suffix'] : '';
                    ?>
                    <div class="stat-card">
                        <span class="stat-card__number"><?php echo esc_html( $value . $suffix ); ?></span>
                        <?php if ( $label ) : ?>
                            <span class="stat-card__label"><?php echo esc_html( $label ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
