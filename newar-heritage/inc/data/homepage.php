<?php
/**
 * Homepage dynamic data.
 *
 * This file is the single source of truth for homepage section content.
 * Each section uses a typed-style array so it can later be fetched from
 * a CMS or JSON API without changing component markup.
 *
 * Bilingual helpers:
 *  - textEn  : primary display text
 *  - textNe  : optional Nepali/Devanagari subtitle/title
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(

    'hero' => array(
        /**
         * Hero slides.
         *
         * Shape: { id, image, headingEn, headingNe, subtext, ctaText, ctaLink }
         */
        'slides' => array(
            array(
                'id'        => 1,
                'image'     => '',
                'headingEn' => 'PRESERVING THE HEARTBEAT OF THE KATHMANDU VALLEY',
                'headingNe' => '',
                'subtext'   => 'Celebrating Centuries of Culture, Agriculture, and Community',
                'ctaText'   => '',
                'ctaLink'   => '',
            ),
        ),

        /**
         * Optional bilingual helper map.
         * Current priority: customizer > widget > data > legacy fallback
         */
        'headingCustomizer'   => 'newar_heritage_hero_heading',
        'taglineCustomizer'   => 'newar_heritage_hero_tagline',
        'imageCustomizer'     => 'newar_heritage_hero_image',
    ),

    'culture' => array(
        /**
         * Culture highlight block.
         *
         * Shape: { titleEn, titleNe, tags[], bodyEn, bodyNe, tabs[] }
         */
        'titleEn'   => 'Preserving Our Sacred Heritage',
        'titleNe'   => 'सांस्कृतिक सम्पदाको रक्षण',
        'tags'      => array(
            'Festivals',
            'Rituals',
            'Togetherness',
            'Agriculture',
        ),
        'bodyEn'    => 'Our community stands as a guardian of ancient traditions, weaving together the vibrant threads of festivals, sacred rituals, and unwavering togetherness that define the Newar spirit. From the terraced fields of the Kathmandu Valley to the carved wooden courtyards of our ancestors, every stone, every song, and every shared meal carries the heartbeat of a civilization that has thrived for millennia.',
        'tabs'      => array(
            array(
                'id'    => 'festivals',
                'label' => 'Festivals',
                'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"/></svg>',
            ),
            array(
                'id'    => 'rituals',
                'label' => 'Rituals',
                'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
            ),
            array(
                'id'    => 'togetherness',
                'label' => 'Togetherness',
                'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-3-3.87"/><path d="M9 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>',
            ),
        ),

        'titleCustomizer'  => 'newar_heritage_culture_title',
        'subtitleCustomizer' => 'newar_heritage_culture_subtitle',
    ),

    'stats' => array(
        /**
         * Stats banners.
         *
         * Shape: { label, value, suffix }
         */
        'headingCustomizer' => 'newar_heritage_stats_heading',
        'headingDefault'    => 'Our Community Impact',
        'items' => array(
            array(
                'label'  => 'Years of Community Service',
                'value'  => '70',
                'suffix' => '+',
            ),
            array(
                'label'  => 'Families Supported',
                'value'  => '500',
                'suffix' => '+',
            ),
            array(
                'label'  => 'Annual Festivals',
                'value'  => '50',
                'suffix' => '+',
            ),
            array(
                'label'  => 'Community Dedication',
                'value'  => '100',
                'suffix' => '%',
            ),
        ),

        /**
         * Individual customizer fallbacks:
         * stat_{N}_number, stat_{N}_label
         */
        'numberCustomizerPrefix' => 'newar_heritage_stat_',
        'labelCustomizerPrefix'  => 'newar_heritage_stat_',
        'numberDefaults' => array( '70+', '500+', '50+', '100%' ),
        'labelDefaults'  => array(
            'Years of Community Service',
            'Families Supported',
            'Annual Festivals',
            'Community Dedication',
        ),
    ),

    'gallery' => array(
        /**
         * Gallery images.
         *
         * Shape: { id, src, alt, category? }
         */
        'headingCustomizer' => 'newar_heritage_gallery_heading',
        'headingDefault'    => 'Canvas of Our Heritage',
        'images'            => array(),
        'placeholderCount'  => 8,
        'customizerPrefix'  => 'newar_heritage_gallery_image_',
    ),

    'cards' => array(
        /**
         * Heritage cards.
         *
         * Shape: { title, description, link }
         */
        'headingCustomizer' => 'newar_heritage_cards_heading',
        'headingDefault'    => 'Explore Our Heritage',
        'items' => array(
            array(
                'title'       => 'Festivals & Rituals',
                'description' => 'Experience the vibrant tapestry of Newar festivals that have been celebrated for centuries in the Kathmandu Valley.',
                'link'        => '#',
            ),
            array(
                'title'       => 'Agriculture & Food',
                'description' => 'Discover our traditional farming practices and the rich culinary heritage that nourishes our community.',
                'link'        => '#',
            ),
            array(
                'title'       => 'Architecture & Art',
                'description' => 'Marvel at the intricate wood carvings, pagoda temples, and artistic traditions that define our skyline.',
                'link'        => '#',
            ),
            array(
                'title'       => 'Festivals & Calendar',
                'description' => 'From Indra Jatra to Gai Jatra, experience the year-round cycle of celebrations that bind our community together.',
                'link'        => '#',
            ),
        ),
    ),

    'blog' => array(
        /**
         * Latest updates text/config.
         *
         * Shape: { headingCustomizer, postCountCustomizer, categoryCustomizer }
         */
        'headingCustomizer'     => 'newar_heritage_blog_heading',
        'headingDefault'        => 'Latest Updates',
        'postCountCustomizer'   => 'newar_heritage_blog_post_count',
        'postCountDefault'      => 3,
        'categoryCustomizer'    => 'newar_heritage_blog_category',
    ),
);
