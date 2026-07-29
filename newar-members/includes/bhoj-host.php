<?php
/**
 * Organizer Tracking Module.
 *
 * Registers the bhoj_host custom post type,
 * admin list columns with validation, the BS year override
 * settings, and the newar_get_current_bhoj_hosts() helper.
 */

// ── Register bhoj_host CPT ──────────────────────────────

add_action( 'init', 'newar_members_register_bhoj_host_cpt' );

function newar_members_register_bhoj_host_cpt() {
    register_post_type( 'bhoj_host', array(
        'labels'              => array(
            'name'               => __( 'Organizers', 'newar-members' ),
            'singular_name'      => __( 'Organizer', 'newar-members' ),
            'add_new'            => __( 'Add New Year', 'newar-members' ),
            'add_new_item'       => __( 'Add New Year', 'newar-members' ),
            'edit_item'          => __( 'Edit Year', 'newar-members' ),
            'view_item'          => __( 'View Year', 'newar-members' ),
            'search_items'       => __( 'Search Years', 'newar-members' ),
            'not_found'          => __( 'No organizer records found.', 'newar-members' ),
            'not_found_in_trash' => __( 'No organizer records found in Trash.', 'newar-members' ),
            'menu_name'          => __( 'Organizers', 'newar-members' ),
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => 'edit.php?post_type=member',
        'menu_icon'           => 'dashicons-calendar-alt',
        'has_archive'         => false,
        'supports'            => array( 'title' ),
        'show_in_rest'        => false,
    ) );
}

// ── Admin List Columns ──────────────────────────────────

add_filter( 'manage_bhoj_host_posts_columns', 'newar_members_bhoj_host_columns' );

function newar_members_bhoj_host_columns( $columns ) {
    return array(
        'cb'             => '<input type="checkbox" />',
        'title'          => __( 'Year', 'newar-members' ),
        'host_1'         => __( 'Organizer 1', 'newar-members' ),
        'host_2'         => __( 'Organizer 2', 'newar-members' ),
        'notes'          => __( 'Notes', 'newar-members' ),
    );
}

add_action( 'manage_bhoj_host_posts_custom_column', 'newar_members_bhoj_host_column_content', 10, 2 );

function newar_members_bhoj_host_column_content( $column, $post_id ) {
    switch ( $column ) {

        case 'host_1':
            $host_id = intval( get_post_meta( $post_id, 'host_member_1', true ) );
            if ( $host_id ) {
                echo '<a href="' . esc_url( get_edit_post_link( $host_id ) ) . '">' . esc_html( get_the_title( $host_id ) ) . '</a>';
            } else {
                echo '—';
            }
            break;

        case 'host_2':
            $host_id = intval( get_post_meta( $post_id, 'host_member_2', true ) );
            if ( $host_id ) {
                echo '<a href="' . esc_url( get_edit_post_link( $host_id ) ) . '">' . esc_html( get_the_title( $host_id ) ) . '</a>';
            } else {
                echo '—';
            }
            break;

        case 'notes':
            $notes = get_post_meta( $post_id, 'notes', true );
            echo $notes ? esc_html( wp_trim_words( $notes, 10 ) ) : '—';
            break;
    }
}

// ── Sortable Year column ─────────────────────────────────

add_filter( 'manage_edit-bhoj_host_sortable_columns', 'newar_members_bhoj_host_sortable' );

function newar_members_bhoj_host_sortable( $columns ) {
    $columns['title'] = 'title';
    return $columns;
}

// ── Helper: BS year calculation ───────────────────
// Approximation: BS new year begins mid-April (Gregorian).
// Jan–Apr13 → BS year = Gregorian + 56
// Apr14–Dec  → BS year = Gregorian + 57
// This is an approximation, not a precise BS calendar conversion.
// Future maintainers: if higher precision is needed, use a
// dedicated BS calendar library or lookup table.

function newar_get_current_bs_year() {
    $gregorian_year = intval( date( 'Y' ) );
    $month          = intval( date( 'n' ) );
    $day            = intval( date( 'j' ) );

    if ( $month < 4 || ( $month === 4 && $day < 14 ) ) {
        return $gregorian_year + 56;
    }

    return $gregorian_year + 57;
}

// ── Helper: Override BS year from admin settings ──

function newar_get_bs_year_override() {
    return intval( get_option( 'newar_bs_year_override', 0 ) );
}

// ── Helper: Effective BS year (override or calculated) ──

function newar_get_effective_bs_year() {
    $override = newar_get_bs_year_override();

    if ( $override > 0 ) {
        return $override;
    }

    return newar_get_current_bs_year();
}

// ── BS Year Override Settings ──────────────────

add_action( 'admin_init', 'newar_members_settings_init' );

function newar_members_settings_init() {
    register_setting( 'general', 'newar_bs_year_override', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
        'default'           => 0,
    ) );

    add_settings_field(
        'newar_bs_year_override',
        __( 'Current BS Year Override', 'newar-members' ),
        'newar_members_bs_year_override_render',
        'general',
        'default'
    );
}

function newar_members_bs_year_override_render() {
    $value = intval( get_option( 'newar_bs_year_override', 0 ) );
    $calculated = newar_get_current_bs_year();
    ?>
    <label for="newar_bs_year_override">
        <input type="number" id="newar_bs_year_override" name="newar_bs_year_override" value="<?php echo $value ? esc_attr( $value ) : ''; ?>" min="2000" max="2100" style="width:80px;" />
        <span class="description"><?php esc_html_e( 'Leave blank to use the calculated BS year (approximately ' . $calculated . '). Set manually if the auto-calculation is incorrect around the April transition.', 'newar-members' ); ?></span>
    </label>
    <?php
}

// ── Helper: Get current year's hosts ─────────────

function newar_get_current_bhoj_hosts() {
    $year = newar_get_effective_bs_year();

    $records = get_posts( array(
        'post_type'      => 'bhoj_host',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'    => array(
            array(
                'key'     => 'year',
                'value'   => $year,
                'compare' => '=',
                'type'    => 'NUMERIC',
            ),
        ),
    ) );

    if ( empty( $records ) ) {
        return null;
    }

    $post_id = intval( $records[0]->ID );

    return array(
        'post_id'        => $post_id,
        'year'           => $year,
        'host_member_1'  => intval( get_post_meta( $post_id, 'host_member_1', true ) ),
        'host_member_2'  => intval( get_post_meta( $post_id, 'host_member_2', true ) ),
        'notes'          => get_post_meta( $post_id, 'notes', true ),
    );
}