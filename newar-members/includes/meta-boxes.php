<?php
/**
 * Native WordPress meta boxes for member and bhoj_host post types.
 *
 * Replaces ACF field groups with core WP meta box API.
 * Stores all field values in wp_postmeta using the same
 * meta keys that ACF used, so existing data remains readable.
 * No ACF dependency.
 */

// ── Member Post Type Meta Boxes ──────────────────

add_action( 'add_meta_boxes', 'newar_members_add_member_meta_boxes' );

function newar_members_add_member_meta_boxes() {
    add_meta_box(
        'newar_member_details',
        __( 'Member Details', 'newar-members' ),
        'newar_members_member_details_meta_box',
        'member',
        'normal',
        'high'
    );
}

function newar_members_member_details_meta_box( $post ) {
    wp_nonce_field( 'newar_members_save_member_meta', 'newar_members_member_meta_nonce' );

    $first_name   = get_post_meta( $post->ID, 'first_name', true );
    $last_name    = get_post_meta( $post->ID, 'last_name', true );
    $phone        = get_post_meta( $post->ID, 'phone_number', true );
    $address      = get_post_meta( $post->ID, 'address', true );
    $location     = get_post_meta( $post->ID, 'location', true );
    $photo_id     = get_post_meta( $post->ID, 'member_photo', true );
    $display_order = get_post_meta( $post->ID, 'display_order', true );
    $bio          = get_post_meta( $post->ID, 'bio', true );
    $contact_email = get_post_meta( $post->ID, 'contact_email', true );

    if ( is_array( $location ) ) {
        $loc_lat    = isset( $location['lat'] ) ? esc_attr( $location['lat'] ) : '';
        $loc_lng    = isset( $location['lng'] ) ? esc_attr( $location['lng'] ) : '';
        $loc_addr   = isset( $location['address'] ) ? esc_attr( $location['address'] ) : '';
    } else {
        $loc_lat = $loc_lng = $loc_addr = '';
    }

    ?>
    <style>
        .newar-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .newar-meta-grid .newar-meta-full {
            grid-column: 1 / -1;
        }
        .newar-meta-grid label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 13px;
        }
        .newar-meta-grid input[type="text"],
        .newar-meta-grid input[type="email"],
        .newar-meta-grid input[type="number"],
        .newar-meta-grid textarea {
            width: 100%;
        }
        .newar-meta-grid .newar-meta-row {
            margin-bottom: 0;
        }
        .newar-location-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 8px;
        }
        .newar-location-row input {
            width: 100%;
        }
        .newar-photo-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 8px;
            border-radius: 4px;
        }
        .newar-photo-actions {
            margin-top: 4px;
        }
        .newar-photo-actions button {
            margin-right: 4px;
        }
    </style>
    <div class="newar-meta-grid">
        <div class="newar-meta-row">
            <label for="newar_first_name"><?php esc_html_e( 'First Name', 'newar-members' ); ?> *</label>
            <input type="text" id="newar_first_name" name="newar_first_name" value="<?php echo esc_attr( $first_name ); ?>" required />
        </div>
        <div class="newar-meta-row">
            <label for="newar_last_name"><?php esc_html_e( 'Last Name', 'newar-members' ); ?> *</label>
            <input type="text" id="newar_last_name" name="newar_last_name" value="<?php echo esc_attr( $last_name ); ?>" required />
        </div>
        <div class="newar-meta-row">
            <label for="newar_phone"><?php esc_html_e( 'Phone Number', 'newar-members' ); ?></label>
            <input type="text" id="newar_phone" name="newar_phone" value="<?php echo esc_attr( $phone ); ?>" />
        </div>
        <div class="newar-meta-row">
            <label for="newar_contact_email"><?php esc_html_e( 'Contact Email', 'newar-members' ); ?></label>
            <input type="email" id="newar_contact_email" name="newar_contact_email" value="<?php echo esc_attr( $contact_email ); ?>" />
        </div>
        <div class="newar-meta-row newar-meta-full">
            <label for="newar_address"><?php esc_html_e( 'Address', 'newar-members' ); ?></label>
            <textarea id="newar_address" name="newar_address" rows="3"><?php echo esc_textarea( $address ); ?></textarea>
        </div>
        <div class="newar-meta-row newar-meta-full">
            <label><?php esc_html_e( 'Location (Map)', 'newar-members' ); ?></label>
            <div class="newar-location-row">
                <input type="text" name="newar_location_lat" placeholder="Latitude" value="<?php echo esc_attr( $loc_lat ); ?>" />
                <input type="text" name="newar_location_lng" placeholder="Longitude" value="<?php echo esc_attr( $loc_lng ); ?>" />
                <input type="text" name="newar_location_address" placeholder="Address" value="<?php echo esc_attr( $loc_addr ); ?>" />
            </div>
        </div>
        <div class="newar-meta-row newar-meta-full">
            <label><?php esc_html_e( 'Photo', 'newar-members' ); ?></label>
            <div class="newar-photo-actions">
                <button type="button" class="button newar-photo-upload" data-post-id="<?php echo esc_attr( $post->ID ); ?>">
                    <?php esc_html_e( 'Select Photo', 'newar-members' ); ?>
                </button>
                <button type="button" class="button newar-photo-remove" style="display:none;">
                    <?php esc_html_e( 'Remove', 'newar-members' ); ?>
                </button>
            </div>
            <?php if ( $photo_id ) : ?>
                <?php $photo_url = wp_get_attachment_url( $photo_id ); ?>
                <?php if ( $photo_url ) : ?>
                    <img src="<?php echo esc_url( $photo_url ); ?>" alt="" class="newar-photo-preview" />
                <?php endif; ?>
            <?php endif; ?>
            <input type="hidden" id="newar_member_photo" name="newar_member_photo" value="<?php echo esc_attr( $photo_id ); ?>" />
        </div>
        <div class="newar-meta-row">
            <label for="newar_display_order"><?php esc_html_e( 'Display Order', 'newar-members' ); ?></label>
            <input type="number" id="newar_display_order" name="newar_display_order" value="<?php echo esc_attr( $display_order ); ?>" min="0" />
            <p class="description"><?php esc_html_e( 'Lower numbers appear first in the grid.', 'newar-members' ); ?></p>
        </div>
        <div class="newar-meta-row newar-meta-full">
            <label for="newar_bio"><?php esc_html_e( 'Bio', 'newar-members' ); ?></label>
            <textarea id="newar_bio" name="newar_bio" rows="4"><?php echo esc_textarea( $bio ); ?></textarea>
        </div>
    </div>
    <script>
        jQuery(function($) {
            var frame;
            $(document).on('click', '.newar-photo-upload', function(e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                if (frame) { frame.open(); return; }
                frame = wp.media({
                    title: '<?php echo esc_js(__('Select or Upload Photo', 'newar-members')); ?>',
                    button: { text: '<?php echo esc_js(__('Use this photo', 'newar-members')); ?>' },
                    multiple: false
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $('#newar_member_photo').val(attachment.id);
                    $('.newar-photo-preview').attr('src', attachment.sizes.medium.url || attachment.url).show();
                    $('.newar-photo-remove').show();
                });
                frame.open();
            });
            $(document).on('click', '.newar-photo-remove', function() {
                $('#newar_member_photo').val('');
                $('.newar-photo-preview').hide().attr('src', '');
                $(this).hide();
            });
        });
    </script>
    <?php
}

add_action( 'save_post', 'newar_members_save_member_meta' );

function newar_members_save_member_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! isset( $_POST['newar_members_member_meta_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['newar_members_member_meta_nonce'], 'newar_members_save_member_meta' ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'member' ) {
        return;
    }

    $fields = array(
        'newar_first_name'   => 'first_name',
        'newar_last_name'    => 'last_name',
        'newar_phone'        => 'phone_number',
        'newar_address'      => 'address',
        'newar_contact_email' => 'contact_email',
        'newar_member_photo' => 'member_photo',
        'newar_display_order' => 'display_order',
        'newar_bio'          => 'bio',
    );

    foreach ( $fields as $input_name => $meta_key ) {
        if ( isset( $_POST[ $input_name ] ) ) {
            $value = sanitize_text_field( wp_unslash( $_POST[ $input_name ] ) );
            if ( $value === '' ) {
                delete_post_meta( $post_id, $meta_key );
            } else {
                update_post_meta( $post_id, $meta_key, $value );
            }
        }
    }

    $location = array(
        'lat'     => isset( $_POST['newar_location_lat'] ) ? sanitize_text_field( wp_unslash( $_POST['newar_location_lat'] ) ) : '',
        'lng'     => isset( $_POST['newar_location_lng'] ) ? sanitize_text_field( wp_unslash( $_POST['newar_location_lng'] ) ) : '',
        'address' => isset( $_POST['newar_location_address'] ) ? sanitize_text_field( wp_unslash( $_POST['newar_location_address'] ) ) : '',
    );

    if ( empty( array_filter( $location ) ) ) {
        delete_post_meta( $post_id, 'location' );
    } else {
        update_post_meta( $post_id, 'location', $location );
    }
}

// ── Bhoj Host Post Type Meta Boxes ──────────────

add_action( 'add_meta_boxes', 'newar_members_add_bhoj_host_meta_boxes' );

function newar_members_add_bhoj_host_meta_boxes() {
    add_meta_box(
        'newar_bhoj_host_details',
        __( 'Organizer Details', 'newar-members' ),
        'newar_members_bhoj_host_meta_box',
        'bhoj_host',
        'normal',
        'high'
    );
}

function newar_members_bhoj_host_meta_box( $post ) {
    wp_nonce_field( 'newar_members_save_bhoj_host_meta', 'newar_members_bhoj_host_meta_nonce' );

    $year       = get_post_meta( $post->ID, 'year', true );
    $host_1     = get_post_meta( $post->ID, 'host_member_1', true );
    $host_2     = get_post_meta( $post->ID, 'host_member_2', true );
    $notes      = get_post_meta( $post->ID, 'notes', true );

    $members = get_posts( array(
        'post_type'      => 'member',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    ) );

    $member_list = array();
    foreach ( $members as $member ) {
        $member_list[ $member->ID ] = $member->post_title;
    }

    ?>
    <style>
        .newar-bhoj-meta label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 13px;
        }
        .newar-bhoj-meta input[type="number"],
        .newar-bhoj-meta select,
        .newar-bhoj-meta textarea {
            width: 100%;
        }
        .newar-bhoj-meta .newar-bhoj-row {
            margin-bottom: 12px;
        }
    </style>
    <div class="newar-bhoj-meta">
        <div class="newar-bhoj-row">
            <label for="newar_bhoj_year"><?php esc_html_e( 'Year', 'newar-members' ); ?> *</label>
            <input type="number" id="newar_bhoj_year" name="newar_bhoj_year" value="<?php echo esc_attr( $year ); ?>" min="2000" max="2100" required />
        </div>
        <div class="newar-bhoj-row">
                <label for="newar_bhoj_host_1"><?php esc_html_e( 'Organizer 1', 'newar-members' ); ?> *</label>
            <select id="newar_bhoj_host_1" name="newar_bhoj_host_1" required>
                <option value=""><?php esc_html_e( '— Select —', 'newar-members' ); ?></option>
                <?php foreach ( $member_list as $id => $title ) : ?>
                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $host_1, $id ); ?>>
                        <?php echo esc_html( $title ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="newar-bhoj-row">
                <label for="newar_bhoj_host_2"><?php esc_html_e( 'Organizer 2', 'newar-members' ); ?> *</label>
            <select id="newar_bhoj_host_2" name="newar_bhoj_host_2" required>
                <option value=""><?php esc_html_e( '— Select —', 'newar-members' ); ?></option>
                <?php foreach ( $member_list as $id => $title ) : ?>
                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $host_2, $id ); ?>>
                        <?php echo esc_html( $title ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="newar-bhoj-row">
            <label for="newar_bhoj_notes"><?php esc_html_e( 'Notes', 'newar-members' ); ?></label>
            <textarea id="newar_bhoj_notes" name="newar_bhoj_notes" rows="4"><?php echo esc_textarea( $notes ); ?></textarea>
            <p class="description"><?php esc_html_e( 'Date, location, remarks.', 'newar-members' ); ?></p>
        </div>
    </div>
    <?php
}

add_action( 'save_post', 'newar_members_save_bhoj_host_meta' );

function newar_members_save_bhoj_host_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! isset( $_POST['newar_members_bhoj_host_meta_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['newar_members_bhoj_host_meta_nonce'], 'newar_members_save_bhoj_host_meta' ) ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( get_post_type( $post_id ) !== 'bhoj_host' ) {
        return;
    }

    $year   = isset( $_POST['newar_bhoj_year'] ) ? intval( $_POST['newar_bhoj_year'] ) : 0;
    $host_1 = isset( $_POST['newar_bhoj_host_1'] ) ? intval( $_POST['newar_bhoj_host_1'] ) : 0;
    $host_2 = isset( $_POST['newar_bhoj_host_2'] ) ? intval( $_POST['newar_bhoj_host_2'] ) : 0;

    if ( $year < 2000 || $year > 2100 ) {
        set_transient( 'newar_bhoj_duplicate_year', $year, 30 );
        return;
    }

    if ( $host_1 && $host_2 && $host_1 === $host_2 ) {
        set_transient( 'newar_bhoj_same_host', true, 30 );
        return;
    }

    $existing = get_posts( array(
        'post_type'      => 'bhoj_host',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'post_status'    => 'any',
        'meta_query'    => array(
            array(
                'key'     => 'year',
                'value'   => $year,
                'compare' => '=',
            ),
        ),
    ) );

    if ( ! empty( $existing ) ) {
        foreach ( $existing as $existing_id ) {
            if ( intval( $existing_id ) !== $post_id ) {
                set_transient( 'newar_bhoj_duplicate_year', $year, 30 );
                return;
            }
        }
    }

    update_post_meta( $post_id, 'year', $year );
    update_post_meta( $post_id, 'host_member_1', $host_1 );
    update_post_meta( $post_id, 'host_member_2', $host_2 );

    if ( isset( $_POST['newar_bhoj_notes'] ) ) {
        update_post_meta( $post_id, 'notes', sanitize_textarea_field( wp_unslash( $_POST['newar_bhoj_notes'] ) ) );
    }
}

add_action( 'admin_notices', 'newar_members_bhoj_host_admin_notices' );

function newar_members_bhoj_host_admin_notices() {
    $duplicate_year = get_transient( 'newar_bhoj_duplicate_year' );
    if ( $duplicate_year ) {
        delete_transient( 'newar_bhoj_duplicate_year' );
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <strong><?php esc_html_e( 'Duplicate Year', 'newar-members' ); ?></strong> —
                <?php printf(
                    esc_html__( 'An organizer record for %d already exists. Please edit that record instead of creating a duplicate.', 'newar-members' ),
                    esc_html( $duplicate_year )
                ); ?>
            </p>
        </div>
        <?php
    }

    $same_host = get_transient( 'newar_bhoj_same_host' );
    if ( $same_host ) {
        delete_transient( 'newar_bhoj_same_host' );
        ?>
        <div class="notice notice-error is-dismissible">
            <p>
                <strong><?php esc_html_e( 'Duplicate Organizer', 'newar-members' ); ?></strong> —
                <?php esc_html_e( 'Organizer 2 must be a different person than Organizer 1. Please select a different member.', 'newar-members' ); ?>
            </p>
        </div>
        <?php
    }
}