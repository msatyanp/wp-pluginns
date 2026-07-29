<?php
/**
 * Admin list table enhancements for the "member" post type.
 *
 * Custom columns, taxonomy filter dropdowns, JS role hint on
 * tier metabox, protected tier term deletion warning, and
 * default sort order (tier then display_order).
 */

// ── Protected Tier Terms: Prevent Deletion ────────────

add_filter( 'pre_delete_term', 'newar_members_prevent_tier_deletion', 10, 2 );

function newar_members_prevent_tier_deletion( $delete, $term_id ) {
    $term = get_term( $term_id );

    if ( ! $term || 'member_tier' !== $term->taxonomy ) {
        return $delete;
    }

    $protected = array( 'General Member', 'Committee', 'Leadership' );

    if ( in_array( $term->name, $protected, true ) ) {
        set_transient( 'newar_members_protected_term_delete', $term->name, 30 );
        return true;
    }

    return $delete;
}

add_action( 'admin_notices', 'newar_members_tier_protected_notice' );

function newar_members_tier_protected_notice() {
    $term_name = get_transient( 'newar_members_protected_term_delete' );

    if ( ! $term_name ) {
        return;
    }

    delete_transient( 'newar_members_protected_term_delete' );

    ?>
    <div class="notice notice-warning is-dismissible">
        <p>
            <strong><?php esc_html_e( 'Protected Tier Term', 'newar-members' ); ?></strong> —
            <?php printf(
                esc_html__( 'The tier term "%s" cannot be deleted because it is one of the 3 default tier terms. Reassign members to a different tier first.', 'newar-members' ),
                esc_html( $term_name )
            ); ?>
        </p>
    </div>
    <?php
}

// ── Tier → Role JS Hint ──────────────────────────────────────

add_action( 'admin_footer-edit.php', 'newar_members_tier_role_js_hint' );

function newar_members_tier_role_js_hint() {
    $screen = get_current_screen();
    if ( ! $screen || 'member' !== $screen->post_type ) {
        return;
    }

    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            function checkTierRoleHint() {
                var tierCheckboxes = $('#taxonomy-member_tier .selectit input[type="checkbox"]');
                var roleBox = $('#taxonomy-member_role');
                var warning = roleBox.find('.newar-tier-warning');

                var hasTier = false;
                var isCommitteeOrLeadership = false;

                tierCheckboxes.each(function () {
                    if (this.checked) {
                        hasTier = true;
                        var label = $(this).closest('label').text().trim();
                        if (label === 'Committee' || label === 'Leadership') {
                            isCommitteeOrLeadership = true;
                        }
                    }
                });

                if (isCommitteeOrLeadership) {
                    if (warning.length === 0) {
                        roleBox.find('.tabs-panel')
                            .prepend(
                                '<div class="newar-tier-warning notice notice-warning inline" style="margin:6px 0;padding:6px 10px;">' +
                                '<strong><?php echo esc_js(__('Tip:', 'newar-members')); ?></strong> ' +
                                '<?php echo esc_js(__('Select a role term below for this member.', 'newar-members')); ?>' +
                                '</div>'
                            );
                    }
                    roleBox.show();
                } else {
                    warning.remove();
                }
            }

            $(document).on('change', '#taxonomy-member_tier .selectit input[type="checkbox"]', checkTierRoleHint);

            $(document).on('click', '#save-post', function () {
                var tierCheckboxes = $('#taxonomy-member_tier .selectit input[type="checkbox"]:checked');
                var hasCommitteeOrLeadership = false;

                tierCheckboxes.each(function () {
                    var label = $(this).closest('label').text().trim();
                    if (label === 'Committee' || label === 'Leadership') {
                        hasCommitteeOrLeadership = true;
                    }
                });

                if (hasCommitteeOrLeadership) {
                    var hasRole = $('#taxonomy-member_role .selectit input[type="checkbox"]:checked').length > 0;
                    if (!hasRole) {
                        var confirmMsg = '<?php echo esc_js(__('No role term selected. This is a soft suggestion — the member will still save.', 'newar-members')); ?>';
                        if (!confirm(confirmMsg)) {
                            return false;
                        }
                    }
                }
            });
        });
    </script>
    <?php
}

// ── Custom Columns ──────────────────────────────────────────

add_filter( 'manage_member_posts_columns', 'newar_members_admin_columns' );

function newar_members_admin_columns( $columns ) {
    $new_columns = array();

    foreach ( $columns as $key => $label ) {
        if ( 'title' === $key ) {
            $new_columns['member_photo']   = __( 'Photo', 'newar-members' );
            $new_columns['title']           = __( 'Full Name', 'newar-members' );
            $new_columns['member_tier']     = __( 'Tier', 'newar-members' );
            $new_columns['member_role']     = __( 'Role(s)', 'newar-members' );
            $new_columns['display_order']   = __( 'Order', 'newar-members' );
        } else {
            $new_columns[ $key ] = $label;
        }
    }

    return $new_columns;
}

// ── Render Custom Columns ──────────────────────────────────

add_action( 'manage_member_posts_custom_column', 'newar_members_admin_column_content', 10, 2 );

function newar_members_admin_column_content( $column, $post_id ) {
    switch ( $column ) {

        case 'member_photo':
            echo newar_member_avatar( $post_id, 'small' );
            break;

        case 'member_tier':
            $terms = get_the_term_list( $post_id, 'member_tier', '', ', ', '' );
            echo $terms ? $terms : '—';
            break;

        case 'member_role':
            $terms = get_the_term_list( $post_id, 'member_role', '', ', ', '' );
            echo $terms ? $terms : '—';
            break;

        case 'display_order':
            $order = get_post_meta( $post_id, 'display_order', true );
            echo null !== $order ? intval( $order ) : '—';
            break;
    }
}

// ── Sortable Columns ─────────────────────────────────────────

add_filter( 'manage_edit-member_sortable_columns', 'newar_members_sortable_columns' );

function newar_members_sortable_columns( $columns ) {
    $columns['display_order'] = 'display_order';
    return $columns;
}

// ── Default Sort: Tier (Leadership → Committee → General Member), then Display Order ──

add_action( 'pre_get_posts', 'newar_members_admin_default_sort' );

function newar_members_admin_default_sort( $query ) {
    global $pagenow;

    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( 'edit.php' !== $pagenow || 'member' !== $query->get( 'post_type' ) ) {
        return;
    }

    // Respect user-specified sort column.
    // phpcs:ignore WordPress.Security.NonceVerification
    if ( isset( $_GET['orderby'] ) && '' !== $_GET['orderby'] ) {
        return;
    }

    $query->set( 'meta_key', 'display_order' );
    $query->set( 'orderby', 'meta_value_num' );
    $query->set( 'order', 'ASC' );
}

// ── Admin Styles ──────────────────────────────────────

add_action( 'admin_enqueue_scripts', 'newar_members_admin_styles' );

function newar_members_admin_styles( $hook ) {
    if ( 'edit.php' !== $hook ) {
        return;
    }

    $screen = get_current_screen();
    if ( ! $screen || 'member' !== $screen->post_type ) {
        return;
    }

    wp_enqueue_style(
        'newar-members-admin-list',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/css/admin-list.css',
        array(),
        NEWAR_MEMBERS_VERSION
    );

    wp_enqueue_style(
        'newar-members-member-listings',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/css/member-listings.css',
        array( 'newar-members-admin-list' ),
        NEWAR_MEMBERS_VERSION
    );
}