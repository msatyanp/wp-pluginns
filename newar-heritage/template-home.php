<?php
/**
 * Template Name: Home Page
 * Description: Dynamic home page using ACF blocks. Editable from WordPress admin and Site Editor.
 */
?>

<?php get_header(); ?>

<main class="site-main">
    <?php
    if ( function_exists( 'the_acf_blocks' ) ) {
        the_acf_blocks();
    } else {
        get_template_part( 'blocks/block-home-hero' );
        get_template_part( 'blocks/block-culture-highlight' );
        get_template_part( 'blocks/block-stats-section' );
        get_template_part( 'blocks/block-gallery-section' );
        get_template_part( 'blocks/block-heritage-cards' );
    }
    ?>
</main>

<?php get_footer(); ?>
