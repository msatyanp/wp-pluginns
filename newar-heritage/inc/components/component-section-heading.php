<?php
/**
 * Component: Section Heading
 *
 * Usage:
 *   get_template_part( 'inc/components/component-section-heading', null, array(
 *     'id'    => 'stats-heading',
 *     'text'  => 'Our Community Impact',
 *     'class' => '',
 *     'tag'   => 'h2',
 *   ) );
 *
 * @param array $args
 * @param string $args['id']    Heading ID attribute.
 * @param string $args['class'] Optional extra class for the heading.
 * @param string $args['text']  Heading text.
 * @param string $args['tag']   Heading tag, default h2.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'id'    => '',
        'class' => '',
        'text'  => '',
        'tag'   => 'h2',
    )
);

if ( ! $args['text'] ) {
    return;
}

$tag     = tag_escape( $args['tag'] );
$classes = trim( $args['class'] ? $args['class'] : 'stats-section__heading' );
?>

<<?php echo $tag; ?>
    <?php echo $args['id'] ? ' id="' . esc_attr( $args['id'] ) . '"' : ''; ?>
    class="<?php echo esc_attr( $classes ); ?>"
>
    <?php echo esc_html( $args['text'] ); ?>
</<?php echo $tag; ?>>
