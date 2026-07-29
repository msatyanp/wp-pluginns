<?php
/**
 * Uninstall script for Newar Members.
 *
 * Runs ONLY on plugin deletion (not deactivation).
 * Cleans up plugin options while preserving post data.
 *
 * @package NewarMembers
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove plugin options.
$options = array(
    'newar_theme_options',
    'newar_bs_year_override',
);

foreach ( $options as $option ) {
    delete_option( $option );
    delete_site_option( $option );
}

// Remove any transients set by the plugin.
global $wpdb;

$wpdb->query(
    "DELETE FROM {$wpdb->options}
    WHERE option_name LIKE '_transient_newar_%'
    OR option_name LIKE '_transient_timeout_newar_%'"
);
