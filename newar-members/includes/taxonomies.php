<?php
/**
 * Register the member_tier and member_role taxonomies for the
 * "member" post type.
 *
 * tier: hierarchical taxonomy with 3 fixed terms (General Member,
 * Committee, Leadership). Not publicly queryable.
 *
 * role: hierarchical taxonomy for role titles. Managed from its
 * own admin menu under Members > Roles. Not publicly queryable.
 */

add_action( 'init', 'newar_members_register_taxonomies' );

function newar_members_register_taxonomies() {

    // ── member_tier ──
    // Hierarchical like Categories. Hides from front-end URL routing.
    register_taxonomy( 'member_tier', array( 'member' ), array(
        'labels'            => array(
            'name'                       => __( 'Tiers', 'newar-members' ),
            'singular_name'              => __( 'Tier', 'newar-members' ),
            'search_items'               => __( 'Search Tiers', 'newar-members' ),
            'all_items'                  => __( 'All Tiers', 'newar-members' ),
            'parent_item'                => __( 'Parent Tier', 'newar-members' ),
            'parent_item_colon'          => __( 'Parent Tier:', 'newar-members' ),
            'edit_item'                  => __( 'Edit Tier', 'newar-members' ),
            'update_item'                => __( 'Update Tier', 'newar-members' ),
            'add_new_item'               => __( 'Add New Tier', 'newar-members' ),
            'new_item_name'              => __( 'New Tier Name', 'newar-members' ),
            'menu_name'                  => __( 'Tiers', 'newar-members' ),
        ),
        'hierarchical'      => true,
        'public'            => false,
        'publicly_queryable'=> false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => false,
        'rewrite'           => false,
    ) );

    // ── member_role ──
    // Hierarchical taxonomy with its own admin submenu under Members.
    register_taxonomy( 'member_role', array( 'member' ), array(
        'labels'            => array(
            'name'                       => __( 'Roles', 'newar-members' ),
            'singular_name'              => __( 'Role', 'newar-members' ),
            'search_items'               => __( 'Search Roles', 'newar-members' ),
            'all_items'                  => __( 'All Roles', 'newar-members' ),
            'parent_item'                => __( 'Parent Role', 'newar-members' ),
            'parent_item_colon'          => __( 'Parent Role:', 'newar-members' ),
            'edit_item'                  => __( 'Edit Role', 'newar-members' ),
            'update_item'                => __( 'Update Role', 'newar-members' ),
            'add_new_item'               => __( 'Add New Role', 'newar-members' ),
            'new_item_name'              => __( 'New Role Name', 'newar-members' ),
            'menu_name'                  => __( 'Roles', 'newar-members' ),
        ),
        'hierarchical'      => true,
        'public'            => false,
        'publicly_queryable'=> false,
        'show_ui'           => true,
        'show_in_menu'      => 'edit.php?post_type=member',
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => false,
        'rewrite'           => false,
    ) );
}

