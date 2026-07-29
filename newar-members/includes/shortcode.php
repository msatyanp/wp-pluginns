<?php
/**
 * Shortcodes for the newar-members plugin.
 *
 * - [newar_members tier="..."] — card grid or table
 * - [newar_committee_slider tier="committee"] — horizontal auto-scroll slider
 */

add_shortcode( 'newar_members', 'newar_members_shortcode' );
add_shortcode( 'newar_committee_slider', 'newar_committee_slider_shortcode' );

function newar_members_shortcode( $atts ) {

    $atts = shortcode_atts( array(
        'tier' => 'general_member',
    ), $atts, 'newar_members' );

    $allowed_tiers = array( 'general_member', 'committee', 'leadership' );
    $tier_slug = in_array( $atts['tier'], $allowed_tiers, true ) ? $atts['tier'] : 'general_member';

    $members = newar_members_get_members_by_tier( $tier_slug );

    if ( empty( $members ) ) {
        return '<p class="newar-members-placeholder">' . esc_html__( 'No members added yet.', 'newar-members' ) . '</p>';
    }

    $members_json = array();

    foreach ( $members as $post_id ) {
        $first_name = get_post_meta( $post_id, 'first_name', true );
        $last_name  = get_post_meta( $post_id, 'last_name', true );
        $full_name  = trim( $first_name . ' ' . $last_name );
        $name_display = $full_name ?: get_the_title( $post_id );
        $detail_url = get_permalink( $post_id );
        $address    = get_post_meta( $post_id, 'address', true );
        $avatar_small = newar_member_avatar( $post_id, 'small' );
        $avatar_large = newar_member_avatar( $post_id, 'large' );

        $role_terms  = wp_get_post_terms( $post_id, 'member_role', array( 'fields' => 'names' ) );
        $role_display = is_wp_error( $role_terms ) || empty( $role_terms ) ? '' : implode( ', ', $role_terms );

        $members_json[] = array(
            'name'         => $name_display,
            'address'      => $address ?: '',
            'url'          => $detail_url,
            'avatar'       => $avatar_large,
            'avatar_small' => $avatar_small,
            'role'         => $role_display,
        );
    }

    if ( 'general_member' === $tier_slug ) {
        return '<div class="newar-members-wrap">' . newar_members_table_html( $members_json ) . '</div>';
    }

    return '<div class="newar-members-wrap">' . newar_members_card_grid_html( $members_json, $tier_slug ) . '</div>';
}

function newar_members_get_members_by_tier( $tier_slug ) {
    $allowed_tiers = array( 'general_member' => 'General Member', 'committee' => 'Committee', 'leadership' => 'Leadership' );
    $tier_term_name = isset( $allowed_tiers[ $tier_slug ] ) ? $allowed_tiers[ $tier_slug ] : 'General Member';

    $query = new WP_Query( array(
        'post_type'      => 'member',
        'posts_per_page' => -1,
        'tax_query'     => array(
            array(
                'taxonomy' => 'member_tier',
                'field'    => 'name',
                'terms'    => $tier_term_name,
            ),
        ),
        'orderby'        => 'meta_value_num',
        'order'          => 'ASC',
        'meta_key'       => 'display_order',
    ) );

    $post_ids = array();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }

    return $post_ids;
}

function newar_members_table_html( $members ) {
    $json_data = wp_json_encode( $members );

    $output  = '';

    // ── Current year bhoj hosts callout ──
    $hosts = newar_get_current_bhoj_hosts();
    if ( $hosts ) {
        $output .= '<div class="newar-bhoj-callout">';
        $output .= '<h2 class="newar-bhoj-callout__heading">' . sprintf( esc_html__( "This Year's Organizer's (%s)", 'newar-members' ), '<span class="bhoj-year">' . esc_html( $hosts['year'] ) . '</span>' ) . '</h2>';
        $output .= '<div class="newar-bhoj-callout__cards">';

        foreach ( array( 1, 2 ) as $idx ) {
            $host_post_id = intval( $hosts[ "host_member_{$idx}" ] );
            if ( ! $host_post_id ) {
                continue;
            }

            $h_first  = get_post_meta( $host_post_id, 'first_name', true );
            $h_last   = get_post_meta( $host_post_id, 'last_name', true );
            $h_name   = trim( $h_first . ' ' . $h_last );
            $h_avatar = newar_member_avatar( $host_post_id, 'small' );
            $h_url    = get_permalink( $host_post_id );

            $output .= '<div class="newar-bhoj-callout__card">';
            $output .= '<div class="newar-bhoj-callout__avatar">' . $h_avatar . '</div>';
            $output .= '<div class="newar-bhoj-callout__info">';
            if ( $h_url && $h_name ) {
                $output .= '<a href="' . esc_url( $h_url ) . '" class="newar-bhoj-callout__name">' . esc_html( $h_name ) . '</a>';
            } elseif ( $h_name ) {
                $output .= '<span class="newar-bhoj-callout__name">' . esc_html( $h_name ) . '</span>';
            }
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';
        $output .= '</div>';
    }

    $output .= '<div id="newar-members-table-root" class="newar-members-table-wrap" data-members="' . esc_attr( $json_data ) . '">';
    $output .= '<div class="newar-members-search">';
    $output .= '<input type="search" class="newar-table-search" placeholder="Search by name or address..." aria-label="Search members" />';
    $output .= '</div>';
    $output .= '<table class="newar-members-table">';
    $output .= '<thead><tr>';
    $output .= '<th data-sort="name" data-label="S.N.">S.N.</th>';
    $output .= '<th>Photo</th>';
    $output .= '<th data-sort="name" data-label="Name">Name</th>';
    $output .= '<th data-sort="address" data-label="Address">Address</th>';
    $output .= '</tr></thead>';
    $output .= '<tbody></tbody>';
    $output .= '</table>';
    $output .= '<div class="newar-members-bottom">';
    $output .= '<span class="newar-members-info"></span>';
    $output .= '<span class="newar-members-pagination"></span>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

function newar_members_card_grid_html( $members, $tier_slug ) {
    $output = '<div class="newar-members-grid newar-members-grid--' . esc_attr( $tier_slug ) . '">';

    foreach ( $members as $m ) {
        $role_display = ! empty( $m['role'] ) ? esc_html( $m['role'] ) : '';

        $output .= '<div class="newar-member-card">';
        $output .= '<div class="newar-member-card__photo">' . $m['avatar'] . '</div>';
        $output .= '<div class="newar-member-card__body">';

        if ( $m['url'] && $m['name'] ) {
            $output .= '<h3 class="newar-member-card__name"><a href="' . esc_url( $m['url'] ) . '">' . esc_html( $m['name'] ) . '</a></h3>';
        } elseif ( $m['name'] ) {
            $output .= '<h3 class="newar-member-card__name">' . esc_html( $m['name'] ) . '</h3>';
        }

        if ( $role_display ) {
            $output .= '<p class="newar-member-card__role">' . $role_display . '</p>';
        }

        $output .= '</div>';
        $output .= '</div>';
    }

    $output .= '</div>';

    return $output;
}

// ── Committee Slider Shortcode ─────────────────────────────

function newar_committee_slider_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'tier' => 'committee',
    ), $atts, 'newar_committee_slider' );

    $allowed_tiers = array( 'committee', 'leadership' );
    $tier_slug = in_array( $atts['tier'], $allowed_tiers, true ) ? $atts['tier'] : 'committee';

    $post_ids = newar_members_get_members_by_tier( $tier_slug );

    if ( empty( $post_ids ) ) {
        return '';
    }

    $slider_id = 'newar-committee-slider-' . uniqid();

    $output  = '<div class="newar-committee-slider" id="' . esc_attr( $slider_id ) . '" data-tier="' . esc_attr( $tier_slug ) . '">';
    $output .= '<div class="newar-committee-slider__track">';

    foreach ( $post_ids as $post_id ) {
        $first_name = get_post_meta( $post_id, 'first_name', true );
        $last_name  = get_post_meta( $post_id, 'last_name', true );
        $full_name  = trim( $first_name . ' ' . $last_name );
        $name_display = $full_name ?: get_the_title( $post_id );
        $detail_url = get_permalink( $post_id );
        $avatar = newar_member_avatar( $post_id, 'large' );

        $role_terms  = wp_get_post_terms( $post_id, 'member_role', array( 'fields' => 'names' ) );
        $role_display = is_wp_error( $role_terms ) || empty( $role_terms ) ? '' : esc_html( implode( ', ', $role_terms ) );

        $output .= '<div class="newar-committee-slider__slide">';
        $output .= '<div class="newar-committee-slider__slide-inner">';
        $output .= '<div class="newar-committee-slider__photo">' . $avatar . '</div>';
        $output .= '<div class="newar-committee-slider__info">';
        $output .= '<h3 class="newar-committee-slider__name">';
        if ( $detail_url && $name_display ) {
            $output .= '<a href="' . esc_url( $detail_url ) . '">' . esc_html( $name_display ) . '</a>';
        } else {
            $output .= esc_html( $name_display );
        }
        $output .= '</h3>';
        if ( $role_display ) {
            $output .= '<p class="newar-committee-slider__role">' . $role_display . '</p>';
        }
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
    }

    $output .= '</div>';

    $output .= '<button type="button" class="newar-committee-slider__arrow newar-committee-slider__arrow--prev" aria-label="Previous">';
    $output .= '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>';
    $output .= '</button>';

    $output .= '<button type="button" class="newar-committee-slider__arrow newar-committee-slider__arrow--next" aria-label="Next">';
    $output .= '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>';
    $output .= '</button>';

    $output .= '</div>';

    newar_members_maybe_enqueue_slider_assets();

    return $output;
}