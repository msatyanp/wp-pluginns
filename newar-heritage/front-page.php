<?php
/**
 * Front Page Template
 *
 * Used for the site's front page when a static page is set in Settings > Reading.
 *
 * Content priority per section:
 * 1. Widgets (Appearance > Widgets)
 * 2. ACF repeater fields (Homepage Content options page)
 * 3. Data-driven theme components
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

$footer_data = array(
    'footer' => ! empty( $homepage_data['footer'] ) ? $homepage_data['footer'] : array(),
);
get_template_part( 'inc/components/component-footer', null, $footer_data );
