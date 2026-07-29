<?php
/**
 * Newar Heritage — Theme Functions
 *
 * Standalone theme functions file. Registers theme supports, enqueues
 * styles/scripts, registers custom blocks, and adds Customizer options.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NEWAR_HERITAGE_VERSION', '2.0.0' );

/* ==========================================================================
   ENQUEUE STYLES AND SCRIPTS
   ========================================================================== */

add_action( 'wp_enqueue_scripts', 'newar_heritage_enqueue_styles' );

function newar_heritage_enqueue_styles() {
    $theme_version = NEWAR_HERITAGE_VERSION;

    wp_enqueue_style(
        'newar-heritage-fonts',
        'https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;700&family=Noto+Serif+Devanagari:wght@400;700&family=Tiro+Devanagari+Hindi:ital,wght@0,400;0,700;1,400&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'newar-heritage-style',
        get_stylesheet_uri(),
        array( 'newar-heritage-fonts' ),
        $theme_version
    );
}

add_action( 'wp_enqueue_scripts', 'newar_heritage_enqueue_scripts' );

function newar_heritage_enqueue_scripts() {
    wp_enqueue_script(
        'newar-heritage-navigation',
        get_stylesheet_directory_uri() . '/assets/js/navigation.js',
        array(),
        NEWAR_HERITAGE_VERSION,
        true
    );
}

/* ==========================================================================
   THEME SUPPORTS
   ========================================================================== */

add_action( 'after_setup_theme', 'newar_heritage_theme_supports' );

function newar_heritage_theme_supports() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ) );
    add_theme_support( 'custom-logo', array(
        'height'      => 40,
        'width'       => 40,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'custom-background' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'block-templates' );
    add_theme_support( 'block-template-parts' );

    set_post_thumbnail_size( 1200, 800, true );

    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'newar-heritage' ),
        'footer'  => __( 'Footer Menu', 'newar-heritage' ),
    ) );
}

/* ==========================================================================
   WIDGET AREAS
   ========================================================================== */

add_action( 'widgets_init', 'newar_heritage_register_sidebars' );

function newar_heritage_register_sidebars() {
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area', 'newar-heritage' ),
        'id'            => 'footer-widgets',
        'description'   => __( 'Add widgets here to appear in your footer.', 'newar-heritage' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    $home_widgets = array(
        'hero-slider'       => __( 'Home Hero Section', 'newar-heritage' ),
        'about-section'     => __( 'Home About Section', 'newar-heritage' ),
        'programs-section'  => __( 'Home Programs Section', 'newar-heritage' ),
        'events-section'    => __( 'Home Events Section', 'newar-heritage' ),
        'news-section'      => __( 'Home News Section', 'newar-heritage' ),
        'committee-section' => __( 'Home Committee Section', 'newar-heritage' ),
        'gallery-section'   => __( 'Home Gallery Section', 'newar-heritage' ),
        'stats-section'     => __( 'Home Stats Section', 'newar-heritage' ),
        'sponsors-section'  => __( 'Home Sponsors Section', 'newar-heritage' ),
        'cards'             => __( 'Home Heritage Cards', 'newar-heritage' ),
    );

    foreach ( $home_widgets as $id => $label ) {
        register_sidebar( array(
            'name'          => $label,
            'id'            => 'home-' . $id,
            'description'   => sprintf( __( 'Widgets for the %s on the home page. If empty, ACF or default theme content will display.', 'newar-heritage' ), $label ),
            'before_widget' => '<div id="%1$s" class="widget %2$s home-widget">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );
    }
}

function newar_heritage_display_home_widgets( $section_id ) {
    if ( is_active_sidebar( 'home-' . $section_id ) ) : ?>
        <div class="home-widget-area home-widget-area--<?php echo esc_attr( $section_id ); ?>">
            <?php dynamic_sidebar( 'home-' . $section_id ); ?>
        </div>
    <?php endif;
}

require_once get_stylesheet_directory() . '/widgets/custom-widgets.php';

/* ==========================================================================
   ACF OPTIONS PAGE + HOMEPAGE REPEATER FIELDS
   ========================================================================== */

add_action( 'init', 'newar_heritage_register_acf_options_page', 20 );
add_action( 'acf/init', 'newar_heritage_register_acf_fields' );

function newar_heritage_register_acf_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title'  => __( 'Homepage Content', 'newar-heritage' ),
        'menu_title'  => __( 'Homepage Content', 'newar-heritage' ),
        'menu_slug'   => 'homepage-content',
        'capability'  => 'edit_posts',
        'redirect'    => false,
        'position'    => 5.1,
        'icon_url'    => 'dashicons-admin-home',
    ) );
}

function newar_heritage_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key'      => 'newar_heritage_homepage_options',
        'title'    => __( 'Homepage Content', 'newar-heritage' ),
        'location' => array( array( array(
            'param'    => 'options_page',
            'operator' => '==',
            'value'    => 'homepage-content',
        ) ) ),
        'fields'   => array(
            array(
                'key'   => 'newar_heritage_events_repeater',
                'label' => __( 'Events', 'newar-heritage' ),
                'name'  => 'events_repeater',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'newar_heritage_event_date',
                        'label' => __( 'Date', 'newar-heritage' ),
                        'name'  => 'date',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_event_title',
                        'label' => __( 'Title', 'newar-heritage' ),
                        'name'  => 'title',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_event_description',
                        'label' => __( 'Description', 'newar-heritage' ),
                        'name'  => 'description',
                        'type'  => 'textarea',
                    ),
                    array(
                        'key'   => 'newar_heritage_event_location',
                        'label' => __( 'Location', 'newar-heritage' ),
                        'name'  => 'location',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_event_image',
                        'label' => __( 'Image', 'newar-heritage' ),
                        'name'  => 'image',
                        'type'  => 'image',
                    ),
                ),
            ),
            array(
                'key'   => 'newar_heritage_gallery_repeater',
                'label' => __( 'Gallery Images', 'newar-heritage' ),
                'name'  => 'gallery_repeater',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'newar_heritage_gallery_image',
                        'label' => __( 'Image', 'newar-heritage' ),
                        'name'  => 'image',
                        'type'  => 'image',
                    ),
                    array(
                        'key'   => 'newar_heritage_gallery_category',
                        'label' => __( 'Category', 'newar-heritage' ),
                        'name'  => 'category',
                        'type'  => 'text',
                    ),
                ),
            ),
            array(
                'key'   => 'newar_heritage_committee_repeater',
                'label' => __( 'Committee Members', 'newar-heritage' ),
                'name'  => 'committee_repeater',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'newar_heritage_committee_name',
                        'label' => __( 'Name', 'newar-heritage' ),
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_committee_role',
                        'label' => __( 'Role', 'newar-heritage' ),
                        'name'  => 'role',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_committee_photo',
                        'label' => __( 'Photo', 'newar-heritage' ),
                        'name'  => 'photo',
                        'type'  => 'image',
                    ),
                    array(
                        'key'   => 'newar_heritage_committee_socials',
                        'label' => __( 'Socials', 'newar-heritage' ),
                        'name'  => 'socials',
                        'type'  => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key'   => 'newar_heritage_social_platform',
                                'label' => __( 'Platform', 'newar-heritage' ),
                                'name'  => 'platform',
                                'type'  => 'text',
                            ),
                            array(
                                'key'   => 'newar_heritage_social_url',
                                'label' => __( 'URL', 'newar-heritage' ),
                                'name'  => 'url',
                                'type'  => 'url',
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'key'   => 'newar_heritage_stats_repeater',
                'label' => __( 'Stats', 'newar-heritage' ),
                'name'  => 'stats_repeater',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'newar_heritage_stat_label',
                        'label' => __( 'Label', 'newar-heritage' ),
                        'name'  => 'label',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_stat_value',
                        'label' => __( 'Value', 'newar-heritage' ),
                        'name'  => 'value',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_stat_suffix',
                        'label' => __( 'Suffix', 'newar-heritage' ),
                        'name'  => 'suffix',
                        'type'  => 'text',
                    ),
                ),
            ),
            array(
                'key'   => 'newar_heritage_sponsors_repeater',
                'label' => __( 'Sponsors', 'newar-heritage' ),
                'name'  => 'sponsors_repeater',
                'type'  => 'repeater',
                'sub_fields' => array(
                    array(
                        'key'   => 'newar_heritage_sponsor_name',
                        'label' => __( 'Name', 'newar-heritage' ),
                        'name'  => 'name',
                        'type'  => 'text',
                    ),
                    array(
                        'key'   => 'newar_heritage_sponsor_logo',
                        'label' => __( 'Logo', 'newar-heritage' ),
                        'name'  => 'logo',
                        'type'  => 'image',
                    ),
                    array(
                        'key'   => 'newar_heritage_sponsor_link',
                        'label' => __( 'Link', 'newar-heritage' ),
                        'name'  => 'link',
                        'type'  => 'url',
                    ),
                ),
            ),
        ),
    ) );
}

function newar_heritage_acf_repeater_to_data( $repeater_name, $fields, $args = array() ) {
    if ( ! function_exists( 'have_rows' ) || ! have_rows( $repeater_name, 'option' ) ) {
        return array();
    }

    $items = array();
    $src_field = ! empty( $args['src_field'] ) ? $args['src_field'] : '';
    $alt_field = ! empty( $args['alt_field'] ) ? $args['alt_field'] : '';

    while ( have_rows( $repeater_name, 'option' ) ) {
        the_row();
        $item = array();

        foreach ( $fields as $field ) {
            $value = get_sub_field( $field );

            if ( $field === 'image' && is_array( $value ) ) {
                $item['src'] = ! empty( $value['url'] ) ? $value['url'] : '';
                $item['alt'] = ! empty( $value['alt'] ) ? $value['alt'] : ( ! empty( $alt_field ) ? get_sub_field( $alt_field ) : '' );
                continue;
            }

            if ( $field === 'photo' && is_array( $value ) ) {
                $item['photo'] = ! empty( $value['url'] ) ? $value['url'] : '';
                continue;
            }

            if ( $field === 'logo' && is_array( $value ) ) {
                $item['logo'] = ! empty( $value['url'] ) ? $value['url'] : '';
                continue;
            }

            $item[ $field ] = is_array( $value ) ? maybe_serialize( $value ) : $value;
        }

        if ( ! empty( $src_field ) && empty( $item['src'] ) ) {
            $item['src'] = get_sub_field( $src_field );
        }

        $items[] = $item;
    }

    return $items;
}

/* ==========================================================================
   HAMBURGER MENU TOGGLE
   ========================================================================== */

add_action( 'wp_footer', 'newar_heritage_hamburger_script' );

function newar_heritage_hamburger_script() {
    ?>
    <script>
    ( function () {
        var toggle = document.querySelector( '.hamburger-toggle' );
        var nav    = document.querySelector( '.primary-nav' );
        var overlay = document.querySelector( '.nav-overlay' );

        if ( ! toggle || ! nav ) {
            return;
        }

        toggle.addEventListener( 'click', function () {
            var isOpen = toggle.classList.toggle( 'open' );
            nav.classList.toggle( 'open' );
            if ( overlay ) {
                overlay.classList.toggle( 'visible', isOpen );
            }
            toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
        } );

        if ( overlay ) {
            overlay.addEventListener( 'click', function () {
                toggle.classList.remove( 'open' );
                nav.classList.remove( 'open' );
                overlay.classList.remove( 'visible' );
                toggle.setAttribute( 'aria-expanded', 'false' );
            } );
        }

        nav.addEventListener( 'click', function ( e ) {
            if ( e.target.closest( 'a' ) && window.innerWidth <= 767 ) {
                toggle.classList.remove( 'open' );
                nav.classList.remove( 'open' );
                if ( overlay ) {
                    overlay.classList.remove( 'visible' );
                }
                toggle.setAttribute( 'aria-expanded', 'false' );
            }
        } );
    } )();
    </script>
    <?php
}

/* ==========================================================================
   SVG PATTERN HELPER
   ========================================================================== */

function newar_heritage_get_pattern( $name ) {
    $path = get_stylesheet_directory() . '/assets/patterns/' . $name . '.svg';
    if ( ! file_exists( $path ) ) {
        return '';
    }
    $svg = file_get_contents( $path );
    $svg = trim( $svg );
    $svg = str_replace( array( "\n", "\r", "\t" ), '', $svg );
    $svg = preg_replace( '/\s+/', ' ', $svg );
    return 'data:image/svg+xml,' . urlencode( $svg );
}

/* ==========================================================================
   PAGE TEMPLATE REGISTRATION
   ========================================================================== */

add_filter( 'theme_page_templates', 'newar_heritage_register_page_templates' );

function newar_heritage_register_page_templates( $templates ) {
    $templates['template-home.php'] = __( 'Home Page (Dynamic)', 'newar-heritage' );
    return $templates;
}

/* ==========================================================================
   CUSTOM BLOCKS
   ========================================================================== */

add_action( 'init', 'newar_heritage_register_home_block_category' );

function newar_heritage_register_home_block_category() {
    if ( function_exists( 'register_block_category' ) ) {
        register_block_category( 'newar-home', array(
            'label' => 'Home Page',
            'icon'  => 'admin-home',
        ) );
    }
}

add_action( 'init', 'newar_heritage_register_home_blocks' );

function newar_heritage_register_home_blocks() {
    $block_names = array(
        'home-hero',
        'culture-highlight',
        'stats-section',
        'gallery-section',
        'heritage-cards',
    );

    foreach ( $block_names as $block_name ) {
        $block_dir = get_stylesheet_directory() . '/blocks/' . $block_name;
        $block_json = $block_dir . '/block.json';

        if ( file_exists( $block_json ) ) {
            register_block_type( $block_dir );
        }
    }
}

if ( ! function_exists( 'the_acf_blocks' ) ) {
    function the_acf_blocks() {
        get_template_part( 'blocks/block-home-hero' );
        get_template_part( 'blocks/block-culture-highlight' );
        get_template_part( 'blocks/block-stats-section' );
        get_template_part( 'blocks/block-gallery-section' );
        get_template_part( 'blocks/block-heritage-cards' );
    }
}

/* ==========================================================================
   FRONT PAGE TEMPLATE LOADER
   ========================================================================== */

add_filter( 'template_include', 'newar_heritage_load_home_template' );

function newar_heritage_load_home_template( $template ) {
    if ( is_front_page() ) {
        if ( 'page' === get_option( 'show_on_front' ) ) {
            $custom_template = locate_template( array( 'front-page.php' ) );
            if ( $custom_template ) {
                return $custom_template;
            }
        }

        $custom_template = locate_template( array( 'home.php' ) );
        if ( $custom_template ) {
            return $custom_template;
        }
    }
    return $template;
}

/* ==========================================================================
   CUSTOMIZER SETTINGS
   ========================================================================== */

add_action( 'customize_register', 'newar_heritage_customize_register' );

function newar_heritage_customize_register( $wp_customize ) {
    $blogname_setting = $wp_customize->get_setting( 'blogname' );
    if ( $blogname_setting ) {
        $blogname_setting->transport = 'postMessage';
    }

    $blogdescription_setting = $wp_customize->get_setting( 'blogdescription' );
    if ( $blogdescription_setting ) {
        $blogdescription_setting->transport = 'postMessage';
    }

    $wp_customize->add_section( 'newar_heritage_design_options', array(
        'title'    => __( 'Design Options', 'newar-heritage' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'newar_heritage_primary_color', array(
        'default'           => '#511b20',
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'theme_mod',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'newar_heritage_primary_color',
        array(
            'label'    => __( 'Primary Color', 'newar-heritage' ),
            'section'  => 'newar_heritage_design_options',
            'settings' => 'newar_heritage_primary_color',
        )
    ) );

    $wp_customize->add_setting( 'newar_heritage_accent_color', array(
        'default'           => '#c93f00',
        'sanitize_callback' => 'sanitize_hex_color',
        'type'              => 'theme_mod',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'newar_heritage_accent_color',
        array(
            'label'    => __( 'Accent Color', 'newar-heritage' ),
            'section'  => 'newar_heritage_design_options',
            'settings' => 'newar_heritage_accent_color',
        )
    ) );

    $wp_customize->add_section( 'newar_heritage_home_content', array(
        'title'    => __( 'Home Page Content', 'newar-heritage' ),
        'priority' => 40,
    ) );

    $home_settings = array(
        'newar_heritage_hero_heading' => array(
            'default'           => 'PRESERVING THE HEARTBEAT OF THE KATHMANDU VALLEY',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Hero Heading',
        ),
        'newar_heritage_hero_tagline' => array(
            'default'           => 'Celebrating Centuries of Culture, Agriculture, and Community',
            'sanitize_callback' => 'sanitize_textarea_field',
            'label'             => 'Hero Tagline',
        ),
        'newar_heritage_culture_title' => array(
            'default'           => 'Preserving Our Sacred Heritage',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Culture Section Title',
        ),
        'newar_heritage_culture_subtitle' => array(
            'default'           => 'सांस्कृतिक सम्पदाको रक्षण',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Culture Section Subtitle',
        ),
        'newar_heritage_stats_heading' => array(
            'default'           => 'Our Community Impact',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stats Section Heading',
        ),
        'newar_heritage_stat_1_number' => array(
            'default'           => '70+',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 1 Number',
        ),
        'newar_heritage_stat_1_label' => array(
            'default'           => 'Years of Community Service',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 1 Label',
        ),
        'newar_heritage_stat_2_number' => array(
            'default'           => '500+',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 2 Number',
        ),
        'newar_heritage_stat_2_label' => array(
            'default'           => 'Families Supported',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 2 Label',
        ),
        'newar_heritage_stat_3_number' => array(
            'default'           => '50+',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 3 Number',
        ),
        'newar_heritage_stat_3_label' => array(
            'default'           => 'Annual Festivals',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 3 Label',
        ),
        'newar_heritage_stat_4_number' => array(
            'default'           => '100%',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 4 Number',
        ),
        'newar_heritage_stat_4_label' => array(
            'default'           => 'Community Dedication',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Stat 4 Label',
        ),
        'newar_heritage_gallery_heading' => array(
            'default'           => 'Canvas of Our Heritage',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Gallery Section Heading',
        ),
        'newar_heritage_cards_heading' => array(
            'default'           => 'Explore Our Heritage',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Heritage Cards Heading',
        ),
        'newar_heritage_blog_heading' => array(
            'default'           => 'Latest Updates',
            'sanitize_callback' => 'sanitize_text_field',
            'label'             => 'Latest Updates Heading',
        ),
        'newar_heritage_blog_category' => array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'label'             => 'Latest Updates Category',
        ),
        'newar_heritage_blog_post_count' => array(
            'default'           => '3',
            'sanitize_callback' => 'absint',
            'label'             => 'Latest Updates Post Count',
        ),
    );

    foreach ( $home_settings as $setting_id => $args ) {
        $control_type = ( $setting_id === 'newar_heritage_hero_tagline' ) ? 'textarea' : 'text';

        $wp_customize->add_setting( $setting_id, array(
            'default'           => $args['default'],
            'sanitize_callback' => $args['sanitize_callback'],
            'type'              => 'theme_mod',
        ) );

        $wp_customize->add_control( $setting_id, array(
            'label'   => $args['label'],
            'section' => 'newar_heritage_home_content',
            'type'    => $control_type,
        ) );
    }

    $categories = get_categories( array( 'hide_empty' => false ) );
    $category_choices = array( '' => __( 'All Categories', 'newar-heritage' ) );
    foreach ( $categories as $category ) {
        $category_choices[ $category->term_id ] = $category->name;
    }

    $wp_customize->add_setting( 'newar_heritage_blog_category', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'type'              => 'theme_mod',
    ) );

    $wp_customize->add_control( 'newar_heritage_blog_category', array(
        'label'    => __( 'Latest Updates Category', 'newar-heritage' ),
        'section'  => 'newar_heritage_home_content',
        'type'     => 'select',
        'choices'  => $category_choices,
    ) );

    $wp_customize->add_setting( 'newar_heritage_blog_post_count', array(
        'default'           => '3',
        'sanitize_callback' => 'absint',
        'type'              => 'theme_mod',
    ) );

    $wp_customize->add_control( 'newar_heritage_blog_post_count', array(
        'label'   => __( 'Latest Updates Post Count', 'newar-heritage' ),
        'section' => 'newar_heritage_home_content',
        'type'    => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
        ),
    ) );

    $wp_customize->add_section( 'newar_heritage_home_images', array(
        'title'    => __( 'Home Page Images', 'newar-heritage' ),
        'priority' => 45,
    ) );

    $wp_customize->add_setting( 'newar_heritage_hero_image', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'type'              => 'theme_mod',
    ) );

    $wp_customize->add_control( new WP_Customize_Media_Control(
        $wp_customize,
        'newar_heritage_hero_image',
        array(
            'label'    => __( 'Hero Visual Image', 'newar-heritage' ),
            'section'  => 'newar_heritage_home_images',
            'settings' => 'newar_heritage_hero_image',
            'mime_type' => 'image',
        )
    ) );

    for ( $i = 1; $i <= 8; $i++ ) {
        $wp_customize->add_setting( 'newar_heritage_gallery_image_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'type'              => 'theme_mod',
        ) );

        $wp_customize->add_control( new WP_Customize_Media_Control(
            $wp_customize,
            'newar_heritage_gallery_image_' . $i,
            array(
                'label'    => sprintf( __( 'Gallery Image %d', 'newar-heritage' ), $i ),
                'section'  => 'newar_heritage_home_images',
                'settings' => 'newar_heritage_gallery_image_' . $i,
                'mime_type' => 'image',
            )
        ) );
    }
}

/* ==========================================================================
   CUSTOMIZER MEDIA UPLOAD JS
   ========================================================================== */

add_action( 'customize_controls_enqueue_scripts', 'newar_heritage_customizer_media_js' );

function newar_heritage_customizer_media_js() {
    wp_enqueue_script( 'newar-heritage-customizer-media', get_stylesheet_directory_uri() . '/assets/js/customizer-media.js', array( 'customize-controls', 'jquery' ), '2.0.0', true );
}

/* ==========================================================================
   DYNAMIC CSS FROM CUSTOMIZER
   ========================================================================== */

add_action( 'wp_head', 'newar_heritage_dynamic_css' );

function newar_heritage_dynamic_css() {
    $primary = get_theme_mod( 'newar_heritage_primary_color', '#511b20' );
    $accent  = get_theme_mod( 'newar_heritage_accent_color', '#c93f00' );
    ?>
    <style id="newar-heritage-dynamic-css">
        :root {
            --color-chocolate-cosmos: <?php echo esc_html( $primary ); ?>;
            --color-sinopia: <?php echo esc_html( $accent ); ?>;
        }
    </style>
    <?php
}
