<?php
/**
 * Avatar helper — CSS-only initials fallback and photo display.
 *
 * The circle container (.newar-member-card__photo) is styled by the theme's
 * style.css (100x100px circle with gold border). This function only
 * outputs the inner <img> or <span> — no width/height on the element —
 * letting the CSS handle sizing so the photo fills the full circle.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render a member avatar: uploaded photo filling the circle if set,
 * otherwise a CSS-styled circle with initials.
 *
 * @param  int    $post_id Post ID. Defaults to current post.
 * @param  string $size    Image size: 'thumbnail' (36x36), 'small' (32x32), or 'large' (100x100).
 * @return string          HTML img tag or styled <span> with initials.
 */
function newar_member_avatar( $post_id = null, $size = 'thumbnail' ) {

    if ( null === $post_id ) {
        $post_id = get_the_ID();
    }

    if ( ! $post_id ) {
        return newar_member_initials_box( '' );
    }

    $photo = get_post_meta( $post_id, 'member_photo', true );

    if ( ! empty( $photo ) ) {
        $url = '';

        if ( is_array( $photo ) ) {
            $url = isset( $photo['url'] ) ? $photo['url'] : '';
        } elseif ( is_numeric( $photo ) ) {
            $url = wp_get_attachment_url( $photo );
        } else {
            $url = esc_url( $photo );
        }

        if ( ! empty( $url ) ) {
            $first_name = get_post_meta( $post_id, 'first_name', true );
            $last_name  = get_post_meta( $post_id, 'last_name', true );
            $alt = ( $first_name || $last_name ) ? esc_attr( trim( $first_name . ' ' . $last_name ) ) : esc_attr__( 'Member photo', 'newar-members' );

            $thumb_class = 'newar-member-thumb';
            if ( 'small' === $size ) {
                $thumb_class .= ' newar-member-thumb--small';
            } elseif ( 'large' === $size ) {
                $thumb_class .= ' newar-member-thumb--lg';
            }

            return sprintf(
                '<img src="%s" alt="%s" class="newar-member-photo %s" loading="lazy" />',
                esc_url( $url ),
                $alt,
                esc_attr( $thumb_class )
            );
        }
    }

    return newar_member_initials_box( $post_id, $size );
}

/**
 * Render a plain CSS-styled circle with initials text.
 * No SVG — a <span> with text, styled by the theme's CSS.
 *
 * @param  int|string $post_id Post ID, or empty string for no-name fallback.
 * @param  string     $size    Image size: 'thumbnail', 'small', or 'large'.
 * @return string HTML span with initials inside a styled circle.
 */
function newar_member_initials_box( $post_id, $size = 'thumbnail' ) {

    $first_name = '';
    $last_name  = '';

    if ( is_numeric( $post_id ) && $post_id > 0 ) {
        $first_name = get_post_meta( $post_id, 'first_name', true );
        $last_name  = get_post_meta( $post_id, 'last_name', true );
    }

    $initials = newar_member_get_initials( $first_name, $last_name );

    $thumb_class = 'newar-member-initials newar-member-thumb';
    if ( 'small' === $size ) {
        $thumb_class .= ' newar-member-thumb--small';
    } elseif ( 'large' === $size ) {
        $thumb_class .= ' newar-member-thumb--lg';
    }

    return '<span class="' . esc_attr( $thumb_class ) . '">' . esc_html( $initials ) . '</span>';
}

/**
 * Extract initials from first_name and last_name.
 * Falls back gracefully when names are empty or missing.
 *
 * @param  string $first_name
 * @param  string $last_name
 * @return string One or two initials, or "?" if both empty.
 */
function newar_member_get_initials( $first_name, $last_name ) {

    $first_initial = '';
    $last_initial  = '';

    if ( ! empty( $first_name ) && is_string( $first_name ) ) {
        $trimmed = trim( $first_name );
        if ( '' !== $trimmed ) {
            $first_initial = mb_substr( $trimmed, 0, 1 );
        }
    }

    if ( ! empty( $last_name ) && is_string( $last_name ) ) {
        $trimmed = trim( $last_name );
        if ( '' !== $trimmed ) {
            $last_initial = mb_substr( $trimmed, 0, 1 );
        }
    }

    if ( '' === $first_initial && '' === $last_initial ) {
        return '?';
    }

    return strtoupper( $first_initial . $last_initial );
}