<?php
/**
 * WP-CLI Commands for Newar Members Plugin.
 *
 * Commands:
 *   wp newar setup_pages      — Create Members/Committee/Leadership pages + menu
 *   wp newar migrate-names    — Migrate full_name custom field into first_name + last_name
 *   wp newar reset-all-members — Delete all member posts (with loud confirmation)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    WP_CLI::add_command( 'newar', 'Newar_CLI_Command' );
}

class Newar_CLI_Command {

    /**
     * Create Members/Committee/Leadership pages and add to nav menu.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Recreate pages that already exist (deletes and re-creates).
     *
     * ## EXAMPLES
     *
     *     wp newar setup_pages
     *     wp newar setup_pages --force
     */
    public function setup_pages( $args, $assoc_args ) {
        $force = ! empty( $assoc_args['force'] );

        $pages = array(
            array(
                'title'   => 'Members',
                'slug'    => 'members',
                'content' => '[newar_members tier="general_member"]',
            ),
            array(
                'title'   => 'Committee',
                'slug'    => 'committee',
                'content' => '[newar_members tier="committee"]',
            ),
            array(
                'title'   => 'Leadership',
                'slug'    => 'leadership',
                'content' => '[newar_members tier="leadership"]',
            ),
        );

        $menu_name = 'Main Menu';
        $menu_loc  = 'primary';

        $menu = wp_get_nav_menu_object( $menu_name );
        if ( ! $menu ) {
            $menu_id = wp_create_nav_menu( $menu_name );
            if ( ! is_wp_error( $menu_id ) ) {
                $menu = wp_get_nav_menu_object( $menu_id );
                $locations = get_theme_mod( 'nav_menu_locations', array() );
                $locations[ $menu_loc ] = $menu->term_id;
                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }

        $menu_id = $menu ? $menu->term_id : 0;

        $created = 0;

        foreach ( $pages as $page_data ) {
            $existing = get_page_by_path( $page_data['slug'], OBJECT, 'page' );

            if ( $existing && ! $force ) {
                WP_CLI::line(
                    sprintf(
                        __( 'Page "%s" already exists. Skipping. Use --force to recreate.', 'newar-members' ),
                        $page_data['title']
                    )
                );
                continue;
            }

            if ( $existing && $force ) {
                wp_delete_post( $existing->ID, true );
            }

            $post_id = wp_insert_post( array(
                'post_title'   => $page_data['title'],
                'post_name'    => $page_data['slug'],
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_content' => $page_data['content'],
            ), true );

            if ( is_wp_error( $post_id ) ) {
                WP_CLI::warning(
                    sprintf(
                        __( 'Failed to create page "%s": %s', 'newar-members' ),
                        $page_data['title'],
                        $post_id->get_error_message()
                    )
                );
                continue;
            }

            if ( $menu_id ) {
                $items = wp_get_nav_menu_items( $menu_id );
                $exists = false;
                if ( ! is_wp_error( $items ) ) {
                    foreach ( $items as $item ) {
                        if ( $item->object_id == $post_id && $item->object === 'page' ) {
                            $exists = true;
                            break;
                        }
                    }
                }
                if ( ! $exists ) {
                    wp_update_nav_menu_item( $menu_id, 0, array(
                        'menu-item-title'     => $page_data['title'],
                        'menu-item-object-id' => $post_id,
                        'menu-item-object'    => 'page',
                        'menu-item-type'      => 'post_type',
                        'menu-item-status'    => 'publish',
                    ) );
                }
            }

            $created++;
        }

        WP_CLI::success(
            sprintf(
                __( 'Setup complete! Created/updated %d page(s).', 'newar-members' ),
                $created
            )
        );

        WP_CLI::line( __( 'Page URLs:', 'newar-members' ) );
        foreach ( $pages as $page_data ) {
            $existing = get_page_by_path( $page_data['slug'], OBJECT, 'page' );
            if ( $existing ) {
                WP_CLI::line( '  ' . get_permalink( $existing->ID ) );
            }
        }
    }

/**
 * Migrate existing full_name custom field into first_name + last_name.
     *
     * Finds every member post with a full_name value, splits it into
     * first_name (first word) and last_name (remaining words), saves
     * the new fields, and removes the old full_name meta.
     *
     * ## EXAMPLES
     *
     *     wp newar migrate-names
     */
    public function migrate_names( $args, $assoc_args ) {
        $members = get_posts( array(
            'post_type'      => 'member',
            'posts_per_page' => -1,
            'post_status'    => 'any',
            'fields'         => 'ids',
        ) );

        if ( empty( $members ) ) {
            WP_CLI::warning( __( 'No member posts found.', 'newar-members' ) );
            return;
        }

        $migrated = 0;
        $skipped  = 0;

        foreach ( $members as $post_id ) {
            $full_name = get_post_meta( $post_id, 'full_name', true );

            if ( ! $full_name || '' === trim( $full_name ) ) {
                $skipped++;
                continue;
            }

            $parts = preg_split( '/\s+/', trim( $full_name ), 2 );
            $first = $parts[0];
            $last  = isset( $parts[1] ) ? $parts[1] : '';

            delete_post_meta( $post_id, 'full_name' );
            update_post_meta( $post_id, 'first_name', $first );
            update_post_meta( $post_id, 'last_name', $last );

            WP_CLI::line(
                sprintf(
                    __( 'Migrated: "%1$s" → first_name="%2$s" last_name="%3$s" (post %4$d)', 'newar-members' ),
                    $full_name,
                    $first,
                    $last,
                    $post_id
                )
            );

            $migrated++;
        }

        WP_CLI::success(
            sprintf(
                __( 'Migration complete! %d member(s) migrated, %d skipped (no full_name).', 'newar-members' ),
                $migrated,
                $skipped
            )
        );
    }

    /**
     * Create Nepali translation copies of all existing member and bhoj_host posts.
     *
     * For each existing English member/bhoj_host post, creates a linked Nepali
     * version with shared fields (name, photo, phone, address, location) copied
     * over. The bio field is left blank for manual translation.
     *
     * ## EXAMPLES
     *
     *     wp newar create-nepali-versions --allow-root
     */
    public function create_nepali_versions( $args, $assoc_args ) {
        if ( ! function_exists( 'pll_save_post_translations' ) ) {
            WP_CLI::error( __( 'Polylang is not active or not properly configured.', 'newar-members' ) );
            return;
        }

        $en_lang = 'en';
        $ne_lang = 'ne';

        // Check target language exists.
        $languages = PLL()->model->get_languages_list();
        $lang_slugs = wp_list_pluck( $languages, 'slug' );

        if ( ! in_array( $ne_lang, $lang_slugs, true ) ) {
            WP_CLI::error( __( 'Nepali language (ne) is not configured in Polylang. Please add it under Languages > Settings first.', 'newar-members' ) );
            return;
        }

        $post_types = array( 'member', 'bhoj_host' );
        $shared_fields = array( 'first_name', 'last_name', 'phone_number', 'address', 'location', 'member_photo', 'display_order' );
        $translated_fields = array( 'bio' );

        foreach ( $post_types as $post_type ) {
            $posts = get_posts( array(
                'post_type'      => $post_type,
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'fields'         => 'ids',
            ) );

            if ( empty( $posts ) ) {
                WP_CLI::line( sprintf( __( 'No %s posts found.', 'newar-members' ), $post_type ) );
                continue;
            }

            $created_ids = array();

            foreach ( $posts as $post_id ) {
                // Check if Nepali translation already exists.
                $existing_translation = pll_get_post( $post_id, $ne_lang );
                if ( $existing_translation ) {
                    WP_CLI::line( sprintf( __( 'Skipping %s #%d — Nepali translation already exists (%d).', 'newar-members' ), $post_type, $post_id, $existing_translation ) );
                    continue;
                }

                // Get English post data.
                $en_post = get_post( $post_id );
                if ( ! $en_post ) {
                    continue;
                }

                // Create Nepali version.
                $ne_post_id = wp_insert_post( array(
                    'post_title'    => $en_post->post_title,
                    'post_type'     => $post_type,
                    'post_status'   => 'publish',
                    'post_content'  => '',
                    'post_author'   => $en_post->post_author,
                ), true );

                if ( is_wp_error( $ne_post_id ) ) {
                    WP_CLI::warning( sprintf( __( 'Failed to create Nepali copy of %s #%d: %s', 'newar-members' ), $post_type, $post_id, $ne_post_id->get_error_message() ) );
                    continue;
                }

                // Link translations via Polylang.
                pll_save_post_translations( array(
                    $en_lang => $post_id,
                    $ne_lang => $ne_post_id,
                ) );

                // Copy shared fields.
                foreach ( $shared_fields as $field_name ) {
                    $value = get_post_meta( $post_id, $field_name, true );
                    if ( $value ) {
                        update_post_meta( $ne_post_id, $field_name, $value );
                    }
                }

                // Leave translatable fields (bio) empty.
                foreach ( $translated_fields as $field_name ) {
                    // Intentionally leave blank for manual translation.
                }

                // Copy taxonomy assignments.
                $tier_terms = wp_get_post_terms( $post_id, 'member_tier', array( 'fields' => 'ids' ) );
                $role_terms = wp_get_post_terms( $post_id, 'member_role', array( 'fields' => 'ids' ) );
                if ( ! is_wp_error( $tier_terms ) && ! empty( $tier_terms ) ) {
                    wp_set_object_terms( $ne_post_id, $tier_terms, 'member_tier' );
                }
                if ( ! is_wp_error( $role_terms ) && ! empty( $role_terms ) ) {
                    wp_set_object_terms( $ne_post_id, $role_terms, 'member_role' );
                }

                // Copy featured image.
                $thumbnail_id = get_post_thumbnail_id( $post_id );
                if ( $thumbnail_id ) {
                    set_post_thumbnail( $ne_post_id, $thumbnail_id );
                }

                $created_ids[] = $ne_post_id;
                WP_CLI::line( sprintf( __( 'Created Nepali %s copy #%d for English post #%d.', 'newar-members' ), $post_type, $ne_post_id, $post_id ) );
            }

            WP_CLI::success(
                sprintf(
                    __( '%s: Created %d Nepali translation(s).', 'newar-members' ),
                    ucfirst( $post_type ),
                    count( $created_ids )
                )
            );

            if ( ! empty( $created_ids ) ) {
                WP_CLI::line( '' );
                WP_CLI::line( __( '⚠️  Nepali translations created with BLANK bio fields. Please translate the bio text manually:', 'newar-members' ) );
                foreach ( $created_ids as $ne_id ) {
                    $name = get_post_meta( $ne_id, 'first_name', true ) . ' ' . get_post_meta( $ne_id, 'last_name', true );
                    WP_CLI::line( sprintf( '  Post ID %d — %s (English ID: %d)', $ne_id, $name, pll_get_post( $ne_id, $en_lang ) ) );
                }
            }
        }

        WP_CLI::success( __( 'Nepali version creation complete.', 'newar-members' ) );
    }

    /**
     * Delete all member posts permanently.
     *
     * WARNING: This removes every member post along with their
     * taxonomy term relationships and featured images. Use only
     * as a last resort for testing resets.
     *
     * ## OPTIONS
     *
     * [--force]
     * : Skip confirmation prompt.
     *
     * ## EXAMPLES
     *
     *     wp newar reset-all-members --allow-root
     *     wp newar reset-all-members --allow-root --force
     */
    public function reset_all_members( $args, $assoc_args ) {
        $force = ! empty( $assoc_args['force'] );
        $existing_count = wp_count_posts( 'member' )->publish;

        if ( $existing_count === 0 ) {
            WP_CLI::warning( __( 'No published member posts found. Nothing to reset.', 'newar-members' ) );
            return;
        }

        WP_CLI::error(
            sprintf(
                __( 'WARNING: This will permanently delete ALL %d member post(s). This cannot be undone.', 'newar-members' ),
                $existing_count
            )
        );

        if ( ! $force ) {
            WP_CLI::confirm(
                __( 'Are you absolutely sure you want to delete ALL members? Type "yes" to confirm.', 'newar-members' )
            );
        }

        self::delete_all_members();

        WP_CLI::success(
            sprintf(
                __( 'Deleted %d member post(s). All member data has been wiped.', 'newar-members' ),
                $existing_count
            )
        );
    }

    /**
     * Delete all member posts and clean up term relationships.
     */
    private static function delete_all_members() {
        $args = array(
            'post_type'      => 'member',
            'post_status'    => 'any',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        );

        $query = new WP_Query( $args );

        foreach ( $query->posts as $post_id ) {
            $thumbnail_id = get_post_thumbnail_id( $post_id );
            if ( $thumbnail_id ) {
                wp_delete_attachment( $thumbnail_id, true );
            }

            $photo_id = get_post_meta( $post_id, 'member_photo', true );
            if ( is_numeric( $photo_id ) ) {
                wp_delete_attachment( $photo_id, true );
            }

            wp_delete_object_term_relationships( $post_id, array( 'member_tier', 'member_role' ) );

            wp_delete_post( $post_id, true );
        }
    }
}