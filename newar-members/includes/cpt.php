<?php
/**
 * Register custom post types for the newar-members plugin.
 *
 * "member" — community member profiles (existing).
 * "event"  — upcoming community events for the front-page grid.
 */

// ── Member CPT ────────────────────────────────────

add_action( 'init', 'newar_members_register_cpt' );

function newar_members_register_cpt() {
    register_post_type( 'member', array(
        'labels'              => array(
            'name'               => __( 'Members', 'newar-members' ),
            'singular_name'      => __( 'Member', 'newar-members' ),
            'add_new'            => __( 'Add New Member', 'newar-members' ),
            'add_new_item'       => __( 'Add New Member', 'newar-members' ),
            'edit_item'          => __( 'Edit Member', 'newar-members' ),
            'view_item'          => __( 'View Member', 'newar-members' ),
            'search_items'       => __( 'Search Members', 'newar-members' ),
            'not_found'          => __( 'No members found.', 'newar-members' ),
            'not_found_in_trash' => __( 'No members found in Trash.', 'newar-members' ),
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array( 'title', 'custom-fields' ),
        'menu_position'       => 20,
        'show_in_rest'        => true,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'rewrite'             => array( 'slug' => 'member' ),
    ) );
}

