<?php
/**
 * Theme Options Page — native WordPress Settings API.
 *
 * Replaces the ACF options page. Stores all theme options
 * in wp_options using the Settings API for sanitization.
 * No ACF dependency.
 */

add_action( 'admin_menu', 'newar_members_register_options_page' );

function newar_members_register_options_page() {
    add_options_page(
        __( 'Newar Options', 'newar-members' ),
        __( 'Newar Options', 'newar-members' ),
        'manage_options',
        'newar-options',
        'newar_members_theme_options_render'
    );
}

add_action( 'admin_init', 'newar_members_theme_options_init' );

function newar_members_theme_options_init() {
    register_setting( 'newar_theme_options', 'newar_theme_options', array(
        'type'              => 'array',
        'sanitize_callback' => 'newar_members_sanitize_theme_options',
        'default'           => array(),
    ) );

    add_settings_section(
        'newar_theme_main',
        __( 'Theme Settings', 'newar-members' ),
        null,
        'newar-options'
    );

    add_settings_field(
        'hero_bg',
        __( 'Hero Background Image', 'newar-members' ),
        'newar_members_field_image_upload',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'hero_bg', 'label' => __( 'Full-width community/festival photo for the homepage hero.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_number_1',
        __( 'Stat 1 — Number', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_number_1', 'label' => __( 'First stat number.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_label_1',
        __( 'Stat 1 — Label', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_label_1', 'label' => __( 'First stat label.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_number_2',
        __( 'Stat 2 — Number', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_number_2', 'label' => __( 'Second stat number.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_label_2',
        __( 'Stat 2 — Label', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_label_2', 'label' => __( 'Second stat label.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_number_3',
        __( 'Stat 3 — Number', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_number_3', 'label' => __( 'Third stat number.', 'newar-members' ) )
    );

    add_settings_field(
        'stat_label_3',
        __( 'Stat 3 — Label', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'stat_label_3', 'label' => __( 'Third stat label.', 'newar-members' ) )
    );

    add_settings_field(
        'heritage_gallery',
        __( 'Heritage Gallery', 'newar-members' ),
        'newar_members_field_gallery',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'heritage_gallery', 'label' => __( 'Gallery images for the heritage section.', 'newar-members' ) )
    );

    add_settings_field(
        'contact_address',
        __( 'Contact Address', 'newar-members' ),
        'newar_members_field_textarea',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'contact_address', 'label' => __( 'Contact address.', 'newar-members' ) )
    );

    add_settings_field(
        'contact_phone',
        __( 'Contact Phone', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'contact_phone', 'label' => __( 'Contact phone number.', 'newar-members' ) )
    );

    add_settings_field(
        'contact_email',
        __( 'Contact Email', 'newar-members' ),
        'newar_members_field_text',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'contact_email', 'label' => __( 'Contact email address.', 'newar-members' ) )
    );

    add_settings_field(
        'social_facebook',
        __( 'Facebook URL', 'newar-members' ),
        'newar_members_field_url',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'social_facebook', 'label' => __( 'Facebook URL.', 'newar-members' ) )
    );

    add_settings_field(
        'social_twitter',
        __( 'X / Twitter URL', 'newar-members' ),
        'newar_members_field_url',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'social_twitter', 'label' => __( 'X / Twitter URL.', 'newar-members' ) )
    );

    add_settings_field(
        'social_instagram',
        __( 'Instagram URL', 'newar-members' ),
        'newar_members_field_url',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'social_instagram', 'label' => __( 'Instagram URL.', 'newar-members' ) )
    );

    add_settings_field(
        'social_youtube',
        __( 'YouTube URL', 'newar-members' ),
        'newar_members_field_url',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'social_youtube', 'label' => __( 'YouTube URL.', 'newar-members' ) )
    );

    add_settings_field(
        'samaj_branches',
        __( 'Samaj Branches', 'newar-members' ),
        'newar_members_field_repeater',
        'newar-options',
        'newar_theme_main',
        array( 'field_id' => 'samaj_branches', 'label' => __( 'Samaj branch locations.', 'newar-members' ) )
    );
}

function newar_members_sanitize_theme_options( $input ) {
    $sanitized = array();

    if ( isset( $input['hero_bg'] ) ) {
        $sanitized['hero_bg'] = absint( $input['hero_bg'] );
    }

    $stat_fields = array( 'stat_number_1', 'stat_label_1', 'stat_number_2', 'stat_label_2', 'stat_number_3', 'stat_label_3' );
    foreach ( $stat_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $sanitized[ $field ] = sanitize_text_field( wp_unslash( $input[ $field ] ) );
        }
    }

    if ( isset( $input['heritage_gallery'] ) && is_array( $input['heritage_gallery'] ) ) {
        $sanitized['heritage_gallery'] = array_map( 'absint', $input['heritage_gallery'] );
    }

    $text_fields = array( 'contact_address', 'contact_phone', 'contact_email', 'social_facebook', 'social_twitter', 'social_instagram', 'social_youtube' );
    foreach ( $text_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $sanitized[ $field ] = sanitize_text_field( wp_unslash( $input[ $field ] ) );
        }
    }

    if ( isset( $input['samaj_branches'] ) && is_array( $input['samaj_branches'] ) ) {
        $branches = array();
        foreach ( $input['samaj_branches'] as $branch ) {
            $branch_sanitized = array();
            if ( isset( $branch['branch_name'] ) ) {
                $branch_sanitized['branch_name'] = sanitize_text_field( wp_unslash( $branch['branch_name'] ) );
            }
            if ( isset( $branch['branch_url'] ) ) {
                $branch_sanitized['branch_url'] = esc_url_raw( $branch['branch_url'] );
            }
            if ( ! empty( $branch_sanitized ) ) {
                $branches[] = $branch_sanitized;
            }
        }
        $sanitized['samaj_branches'] = $branches;
    }

    return $sanitized;
}

function newar_members_theme_options_render() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }

    $options = get_option( 'newar_theme_options', array() );

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'newar_theme_options' );
            do_settings_sections( 'newar-options' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

function newar_members_field_text( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $value    = isset( $options[ $field_id ] ) ? $options[ $field_id ] : '';
    ?>
    <input type="text" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
    <?php
}

function newar_members_field_textarea( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $value    = isset( $options[ $field_id ] ) ? esc_textarea( $options[ $field_id ] ) : '';
    ?>
    <textarea name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>]" rows="3" class="large-text"><?php echo $value; ?></textarea>
    <?php
}

function newar_members_field_url( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $value    = isset( $options[ $field_id ] ) ? esc_url( $options[ $field_id ] ) : '';
    ?>
    <input type="url" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>]" value="<?php echo esc_attr( $value ); ?>" class="regular-text" />
    <?php
}

function newar_members_field_image_upload( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $image_id = isset( $options[ $field_id ] ) ? absint( $options[ $field_id ] ) : 0;
    $image_url = $image_id ? wp_get_attachment_url( $image_id ) : '';
    ?>
    <input type="hidden" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>]" value="<?php echo esc_attr( $image_id ); ?>" class="newar-image-id" />
    <button type="button" class="button newar-image-upload"><?php esc_html_e( 'Select Image', 'newar-members' ); ?></button>
    <button type="button" class="button newar-image-remove" <?php echo $image_id ? '' : 'style="display:none;"'; ?>>Remove</button>
    <?php if ( $image_url ) : ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="" style="max-width:150px;max-height:150px;margin-top:8px;display:block;" />
    <?php endif; ?>
    <?php
}

function newar_members_field_gallery( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $ids      = isset( $options[ $field_id ] ) ? $options[ $field_id ] : array();
    if ( ! is_array( $ids ) ) {
        $ids = array();
    }
    ?>
    <input type="hidden" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>]" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" class="newar-gallery-ids" />
    <button type="button" class="button newar-gallery-upload"><?php esc_html_e( 'Add Images', 'newar-members' ); ?></button>
    <ul class="newar-gallery-preview" style="list-style:none;padding:0;display:flex;flex-wrap:wrap;gap:8px;margin-top:8px;">
        <?php foreach ( $ids as $id ) : ?>
            <?php $url = wp_get_attachment_url( $id ); ?>
            <?php if ( $url ) : ?>
                <li style="position:relative;display:inline-block;">
                    <img src="<?php echo esc_url( $url ); ?>" alt="" style="width:100px;height:100px;object-fit:cover;" />
                    <button type="button" class="newar-gallery-remove" data-id="<?php echo esc_attr( $id ); ?>" style="position:absolute;top:0;right:0;background:red;color:#fff;border:none;cursor:pointer;">&times;</button>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
    <?php
}

function newar_members_field_repeater( $args ) {
    $field_id = $args['field_id'];
    $options  = get_option( 'newar_theme_options', array() );
    $branches = isset( $options[ $field_id ] ) ? $options[ $field_id ] : array();
    if ( ! is_array( $branches ) ) {
        $branches = array();
    }
    ?>
    <div class="newar-repeater" data-field="<?php echo esc_attr( $field_id ); ?>">
        <?php foreach ( $branches as $index => $branch ) : ?>
            <div class="newar-repeater-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center;">
                <input type="text" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>][<?php echo esc_attr( $index ); ?>][branch_name]" value="<?php echo esc_attr( $branch['branch_name'] ?? '' ); ?>" placeholder="Branch Name" class="regular-text" />
                <input type="url" name="newar_theme_options[<?php echo esc_attr( $field_id ); ?>][<?php echo esc_attr( $index ); ?>][branch_url]" value="<?php echo esc_attr( $branch['branch_url'] ?? '' ); ?>" placeholder="URL" class="regular-text" />
                <button type="button" class="button newar-repeater-remove">Remove</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button newar-repeater-add" data-field="<?php echo esc_attr( $field_id ); ?>">Add Branch</button>
    <script>
        jQuery(function($) {
            $(document).on('click', '.newar-repeater-add', function() {
                var field = $(this).data('field');
                var container = $(this).prev('.newar-repeater');
                var index = container.find('.newar-repeater-row').length;
                var row = '<div class="newar-repeater-row" style="display:flex;gap:8px;margin-bottom:8px;align-items:center;">' +
                    '<input type="text" name="newar_theme_options[' + field + '][' + index + '][branch_name]" placeholder="Branch Name" class="regular-text" />' +
                    '<input type="url" name="newar_theme_options[' + field + '][' + index + '][branch_url]" placeholder="URL" class="regular-text" />' +
                    '<button type="button" class="button newar-repeater-remove">Remove</button>' +
                    '</div>';
                container.append(row);
            });
            $(document).on('click', '.newar-repeater-remove', function() {
                $(this).closest('.newar-repeater-row').remove();
            });
        });
    </script>
    <?php
}

add_action( 'admin_enqueue_scripts', 'newar_members_options_media_scripts' );

function newar_members_options_media_scripts( $hook ) {
    if ( 'settings_page_newar-options' !== $hook ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script(
        'newar-options',
        NEWAR_MEMBERS_PLUGIN_URL . 'assets/js/theme-options.js',
        array( 'jquery' ),
        NEWAR_MEMBERS_VERSION,
        true
    );
}