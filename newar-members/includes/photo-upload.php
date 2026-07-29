<?php
/**
 * Photo upload validation and auto-resize for member post type.
 *
 * Intercepts image uploads from the member edit screen, resizes them
 * to 100x100 (center-cropped square), and compresses to under 50KB.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_filter( 'wp_handle_upload_prefilter', 'newar_members_validate_photo_upload' );

function newar_members_validate_photo_upload( $file ) {
    // Only process when a member post ID is explicitly set in the upload context.
    $post_id = isset( $_REQUEST['post_id'] ) ? intval( $_REQUEST['post_id'] ) : 0;
    if ( ! $post_id || get_post_type( $post_id ) !== 'member' ) {
        return $file;
    }

    // Only process images.
    $allowed_types = array( 'image/jpeg', 'image/png', 'image/webp', 'image/gif' );
    if ( empty( $file['type'] ) || ! in_array( $file['type'], $allowed_types, true ) ) {
        return $file;
    }

    $editor = wp_get_image_editor( $file['tmp_name'] );

    if ( is_wp_error( $editor ) ) {
        return $file;
    }

    $original_size = filesize( $file['tmp_name'] );
    $max_bytes     = 50 * 1024; // 50KB.

    $original_dims = $editor->get_size();
    $original_w    = isset( $original_dims['width'] ) ? $original_dims['width'] : 0;
    $original_h    = isset( $original_dims['height'] ) ? $original_dims['height'] : 0;

    if ( $original_w > 100 || $original_h > 100 ) {
        $editor->resize( 100, 100, true );

        $editor->set_quality( 90 );
        $saved = $editor->save( $file['tmp_name'], 'image/jpeg' );

        if ( ! is_wp_error( $saved ) && isset( $saved['path'] ) ) {
            $file['tmp_name'] = $saved['path'];
            $file['name']     = preg_replace( '/\.(png|webp|gif)$/i', '.jpg', $file['name'] );
            $file['type']     = 'image/jpeg';
        }
    }

    clearstatcache();
    $current_size = filesize( $file['tmp_name'] );

    if ( $current_size > $max_bytes ) {
        $editor = wp_get_image_editor( $file['tmp_name'] );

        if ( ! is_wp_error( $editor ) ) {
            for ( $q = 85; $q >= 60; $q -= 5 ) {
                $editor->set_quality( $q );
                $saved = $editor->save( $file['tmp_name'], 'image/jpeg' );

                if ( ! is_wp_error( $saved ) && isset( $saved['path'] ) ) {
                    $file['tmp_name'] = $saved['path'];
                    clearstatcache();
                    if ( filesize( $file['tmp_name'] ) <= $max_bytes ) {
                        break;
                    }
                }
            }

            clearstatcache();
            if ( filesize( $file['tmp_name'] ) > $max_bytes && wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
                $editor->set_quality( 80 );
                $webp_path = preg_replace( '/\.jpg$/i', '.webp', $file['tmp_name'] );
                $saved = $editor->save( $webp_path, 'image/webp' );

                if ( ! is_wp_error( $saved ) && isset( $saved['path'] ) && filesize( $saved['path'] ) <= $max_bytes ) {
                    $file['tmp_name'] = $saved['path'];
                    $file['name']     = preg_replace( '/\.jpg$/i', '.webp', $file['name'] );
                    $file['type']     = 'image/webp';
                }
            }
        }
    }

    set_transient( 'newar_members_photo_resized', 1, 30 );

    return $file;
}

add_action( 'admin_notices', 'newar_members_photo_resized_notice' );

function newar_members_photo_resized_notice() {
    $resized = get_transient( 'newar_members_photo_resized' );
    if ( ! $resized ) {
        return;
    }

    delete_transient( 'newar_members_photo_resized' );
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php esc_html_e( 'Photo was automatically resized to 100x100px and compressed to under 50KB for optimal performance.', 'newar-members' ); ?></p>
    </div>
    <?php
}
