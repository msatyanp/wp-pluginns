<?php
/**
 * Plugin Name:       Newar Members
 * Description:       Member directory management with custom post types and taxonomies, plus Organizer yearly rotation tracking with native WordPress meta fields, admin validation, and front-end callout display. No ACF dependency.
 * Version:           2.0.0
 * Author:            Newar Heritage Team
 * License:           GPLv2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP:      7.4
 * Requires at least: 6.0
 * Text Domain:       newar-members
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NEWAR_MEMBERS_VERSION', '2.0.0' );
define( 'NEWAR_MEMBERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'NEWAR_MEMBERS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

function newar_members_populate_default_terms() {
    $tier_defaults = array( 'General Member', 'Committee', 'Leadership' );
    foreach ( $tier_defaults as $term_name ) {
        if ( ! term_exists( $term_name, 'member_tier' ) ) {
            wp_insert_term( $term_name, 'member_tier' );
        }
    }

    $role_defaults = array(
        'President',
        'Vice President',
        'Advisor',
        'General Secretary',
        'Cultural Coordinator',
        'Chairperson',
        'Secretary',
        'Treasurer',
        'Committee Member',
        'Event Coordinator',
        'Media & Communications',
    );
    foreach ( $role_defaults as $term_name ) {
        if ( ! term_exists( $term_name, 'member_role' ) ) {
            wp_insert_term( $term_name, 'member_role' );
        }
    }
}

// ── Activation / Deactivation ──────────────────────────

register_activation_hook( __FILE__, 'newar_members_activate' );
register_deactivation_hook( __FILE__, 'newar_members_deactivate' );

function newar_members_activate() {
    newar_members_populate_default_terms();
    flush_rewrite_rules();
}

function newar_members_deactivate() {
    flush_rewrite_rules();
}

// ── Load includes ──

require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/cpt.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/taxonomies.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/meta-boxes.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/options-page.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/photo-upload.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/avatar.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/shortcode.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/admin-list.php';
require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/bhoj-host.php';

// ── Single Member Template Fallback ────────────────────

add_filter( 'template_include', 'newar_members_maybe_load_single_member_template' );

function newar_members_maybe_load_single_member_template( $template ) {
    if ( is_singular( 'member' ) ) {
        $plugin_template = NEWAR_MEMBERS_PLUGIN_DIR . 'templates/single-member.php';
        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }
    }

    return $template;
}

// ── Front-end assets (shortcodes + single member) ────────

add_action( 'wp_enqueue_scripts', 'newar_members_enqueue_frontend_assets' );

function newar_members_enqueue_frontend_assets() {
    if ( is_singular( 'member' ) ) {
        wp_enqueue_style(
            'newar-members-member-listings',
            NEWAR_MEMBERS_PLUGIN_URL . 'assets/css/member-listings.css',
            array(),
            NEWAR_MEMBERS_VERSION
        );

        newar_members_maybe_enqueue_google_maps();
        return;
    }

    if ( ! is_page() && ! is_singular() ) {
        return;
    }

    global $post;
    if ( ! $post ) {
        return;
    }

    $has_members_shortcode = has_shortcode( $post->post_content, 'newar_members' );
    $has_slider_shortcode   = has_shortcode( $post->post_content, 'newar_committee_slider' );

    if ( ! $has_members_shortcode && ! $has_slider_shortcode ) {
        return;
    }

    wp_enqueue_style(
        'newar-members-member-listings',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/css/member-listings.css',
        array(),
        NEWAR_MEMBERS_VERSION
    );

    if ( $has_members_shortcode ) {
        wp_enqueue_script(
            'newar-members-table',
            NEWAR_MEMBERS_PLUGIN_URL . 'assets/js/members-table.js',
            array(),
            NEWAR_MEMBERS_VERSION,
            true
        );

        wp_localize_script(
            'newar-members-table',
            'newarMembersI18n',
            array(
                'showing'    => __( 'Showing', 'newar-members' ),
                'of'         => __( 'of', 'newar-members' ),
                'members'    => __( 'members', 'newar-members' ),
                'prev'       => __( 'Previous', 'newar-members' ),
                'next'       => __( 'Next', 'newar-members' ),
                'page'       => __( 'Page', 'newar-members' ),
                'noMembers'  => __( 'No members added yet.', 'newar-members' ),
            )
        );
    }

    if ( $has_slider_shortcode ) {
        wp_enqueue_script(
            'newar-members-committee-slider',
            NEWAR_MEMBERS_PLUGIN_URL . 'assets/js/committee-slider.js',
            array(),
            NEWAR_MEMBERS_VERSION,
            true
        );
    }
}

function newar_members_maybe_enqueue_google_maps() {
    if ( ! defined( 'GOOGLE_MAPS_API_KEY' ) || empty( GOOGLE_MAPS_API_KEY ) ) {
        return;
    }

    wp_enqueue_script(
        'newar-members-google-maps',
        'https://maps.googleapis.com/maps/api/js?key=' . urlencode( GOOGLE_MAPS_API_KEY ) . '&callback=newarMembersInitMap',
        array(),
        null,
        true
    );
}

function newar_members_maybe_enqueue_slider_assets() {
    static $did = false;
    if ( $did ) {
        return;
    }
    $did = true;

    wp_enqueue_style(
        'newar-members-member-listings',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/css/member-listings.css',
        array(),
        NEWAR_MEMBERS_VERSION
    );

    wp_enqueue_script(
        'newar-members-committee-slider',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/js/committee-slider.js',
        array(),
        NEWAR_MEMBERS_VERSION,
        true
    );
}

// ── WP-CLI commands (only when WP-CLI is active) ──

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require_once NEWAR_MEMBERS_PLUGIN_DIR . 'includes/cli.php';
}