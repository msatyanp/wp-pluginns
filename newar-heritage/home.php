<?php
/**
 * Home / Posts Index Template
 *
 * Used for the blog posts index when Settings > Reading
 * is set to "Your latest posts".
 *
 * This template renders the same home-page sections as
 * front-page.php so Customizer settings are reflected here.
 */

get_header();

$homepage_data = require get_stylesheet_directory() . '/inc/data/homepage.php';

if ( ! empty( $homepage_data['hero'] ) ) {
    if ( is_active_sidebar( 'home-hero-slider' ) ) {
        newar_heritage_display_home_widgets( 'hero-slider' );
    } else {
        get_template_part( 'inc/components/component-hero-slider', null, array( 'args' => $homepage_data['hero'] ) );
    }
}

if ( ! empty( $homepage_data['culture'] ) ) {
    if ( is_active_sidebar( 'home-culture-highlight' ) ) {
        newar_heritage_display_home_widgets( 'culture-highlight' );
    } else {
        get_template_part( 'inc/components/component-culture-highlight', null, array( 'data' => $homepage_data['culture'] ) );
    }
}

if ( ! empty( $homepage_data['stats'] ) ) {
    if ( is_active_sidebar( 'home-stats-section' ) ) {
        newar_heritage_display_home_widgets( 'stats-section' );
    } elseif ( function_exists( 'have_rows' ) && have_rows( 'stats_repeater', 'option' ) ) {
        get_template_part( 'inc/components/component-stats-section', null, array( 'data' => array( 'items' => newar_heritage_acf_repeater_to_data( 'stats_repeater', array( 'label', 'value', 'suffix' ) ) ) ) );
    } else {
        get_template_part( 'inc/components/component-stats-section', null, array( 'data' => $homepage_data['stats'] ) );
    }
}

if ( ! empty( $homepage_data['gallery'] ) ) {
    if ( is_active_sidebar( 'home-gallery-section' ) ) {
        newar_heritage_display_home_widgets( 'gallery-section' );
    } elseif ( function_exists( 'have_rows' ) && have_rows( 'gallery_repeater', 'option' ) ) {
        get_template_part( 'inc/components/component-gallery-section', null, array( 'data' => array( 'images' => newar_heritage_acf_repeater_to_data( 'gallery_repeater', array( 'image', 'category' ), array( 'src_field' => 'image', 'alt_field' => 'category' ) ) ) ) );
    } else {
        get_template_part( 'inc/components/component-gallery-section', null, array( 'data' => $homepage_data['gallery'] ) );
    }
}

if ( ! empty( $homepage_data['cards'] ) ) {
    if ( is_active_sidebar( 'home-cards' ) ) {
        newar_heritage_display_home_widgets( 'cards' );
    } else {
        get_template_part( 'inc/components/component-cards-section', null, array( 'data' => $homepage_data['cards'] ) );
    }
}

if ( ! empty( $homepage_data['blog'] ) ) {
    if ( is_active_sidebar( 'home-news-section' ) ) {
        newar_heritage_display_home_widgets( 'news-section' );
    } else {
        get_template_part( 'inc/components/component-news-layout', null, array( 'args' => $homepage_data['blog'] ) );
    }
}

get_footer();

