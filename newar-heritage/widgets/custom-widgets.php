<?php
/**
 * Newar Heritage — Custom Widgets
 *
 * Custom widgets for each home page section.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================================
   HERO WIDGET
   ========================================================================== */

class Newar_Heritage_Hero_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'newar_heritage_hero',
            __( 'Home Hero Section', 'newar-heritage' ),
            array(
                'description' => __( 'Hero section with heading, tagline, and visual image. Note: Customizer settings take priority over this widget.', 'newar-heritage' ),
                'classname'   => 'newar-heritage-widget newar-heritage-hero-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'PRESERVING THE HEARTBEAT OF THE KATHMANDU VALLEY', 'newar-heritage' );
        $tagline = ! empty( $instance['tagline'] ) ? $instance['tagline'] : __( 'Celebrating Centuries of Culture, Agriculture, and Community', 'newar-heritage' );
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        ?>
        <section class="hero" aria-labelledby="hero-heading">
            <div class="hero__container">
                <div class="hero__content">
                    <h1 id="hero-heading" class="hero__heading-main">
                        <?php echo esc_html( $heading ); ?>
                    </h1>
                    <p class="hero__tagline">
                        <?php echo esc_html( $tagline ); ?>
                    </p>
                    <div class="hero__underline" aria-hidden="true"></div>
                    <div class="hero__scroll-indicator" aria-hidden="true">
                        <span><?php esc_html_e( 'Scroll', 'newar-heritage' ); ?></span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 13l5 5 5-5M7 6l5 5 5-5"/></svg>
                    </div>
                </div>

                <div class="hero__visual">
                    <div class="hero__visual-placeholder">
                        <span class="hero__dev-text hero__dev-text--1">कथमाडौं ज्यापु समाज</span>
                        <span class="hero__dev-text hero__dev-text--2">Newar Heritage</span>
                        <?php if ( $image ) : ?>
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $heading ); ?>" style="max-width: 100%; height: auto; border-radius: var(--radius-md); margin-top: var(--space-md);" />
                        <?php else : ?>
                            <span class="screen-reader-text"><?php esc_html_e( 'Heritage Artwork', 'newar-heritage' ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'PRESERVING THE HEARTBEAT OF THE KATHMANDU VALLEY', 'newar-heritage' );
        $tagline = ! empty( $instance['tagline'] ) ? $instance['tagline'] : __( 'Celebrating Centuries of Culture, Agriculture, and Community', 'newar-heritage' );
        $image   = ! empty( $instance['image'] ) ? $instance['image'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tagline' ) ); ?>"><?php esc_html_e( 'Tagline:', 'newar-heritage' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tagline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tagline' ) ); ?>" rows="3"><?php echo esc_textarea( $tagline ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Image URL:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_url( $image ); ?>" placeholder="https://example.com/image.jpg">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['heading'] = sanitize_text_field( $new_instance['heading'] );
        $instance['tagline'] = sanitize_textarea_field( $new_instance['tagline'] );
        $instance['image']   = esc_url_raw( $new_instance['image'] );
        return $instance;
    }
}

/* ==========================================================================
   CULTURE HIGHLIGHT WIDGET
   ========================================================================== */

class Newar_Heritage_Culture_Highlight_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'newar_heritage_culture_highlight',
            __( 'Home Culture Highlight', 'newar-heritage' ),
            array(
                'description' => __( 'Cultural highlight with title, subtitle, tags, and body text. Note: Customizer settings take priority over this widget.', 'newar-heritage' ),
                'classname'   => 'newar-heritage-widget newar-heritage-culture-highlight-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Preserving Our Sacred Heritage', 'newar-heritage' );
        $subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : __( 'सांस्कृतिक सम्पदाको रक्षण', 'newar-heritage' );
        $tags     = ! empty( $instance['tags'] ) ? explode( ',', $instance['tags'] ) : array( 'Festivals', 'Rituals', 'Togetherness', 'Agriculture' );
        $body     = ! empty( $instance['body'] ) ? $instance['body'] : '';
        ?>
        <section class="culture-highlight" aria-labelledby="culture-title">
            <div class="site-container">
                <div class="culture-highlight__header">
                    <h2 id="culture-title" class="culture-highlight__title">
                        <?php echo esc_html( $title ); ?>
                    </h2>
                    <p class="culture-highlight__subtitle">
                        <?php echo esc_html( $subtitle ); ?>
                    </p>
                </div>

                <div class="culture-highlight__tags">
                    <?php foreach ( $tags as $tag ) : ?>
                        <span class="culture-pill"><?php echo esc_html( trim( $tag ) ); ?></span>
                    <?php endforeach; ?>
                </div>

                <?php if ( $body ) : ?>
                    <p class="culture-highlight__body">
                        <?php echo esc_html( $body ); ?>
                    </p>
                <?php endif; ?>

                <div class="culture-highlight__tabs">
                    <a href="#festivals" class="culture-tab">
                        <span class="culture-tab__icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h7l-5.5 4 2 7L12 16l-6.5 4 2-7L2 9h7z"/></svg>
                        </span>
                        <span class="culture-tab__label"><?php esc_html_e( 'Festivals', 'newar-heritage' ); ?></span>
                    </a>
                    <a href="#rituals" class="culture-tab">
                        <span class="culture-tab__icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </span>
                        <span class="culture-tab__label"><?php esc_html_e( 'Rituals', 'newar-heritage' ); ?></span>
                    </a>
                    <a href="#togetherness" class="culture-tab">
                        <span class="culture-tab__icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-3-3.87"/><path d="M9 21v-2a4 4 0 0 1 3-3.87"/><circle cx="12" cy="7" r="4"/></svg>
                        </span>
                        <span class="culture-tab__label"><?php esc_html_e( 'Togetherness', 'newar-heritage' ); ?></span>
                    </a>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Preserving Our Sacred Heritage', 'newar-heritage' );
        $subtitle = ! empty( $instance['subtitle'] ) ? $instance['subtitle'] : __( 'सांस्कृतिक सम्पदाको रक्षण', 'newar-heritage' );
        $tags     = ! empty( $instance['tags'] ) ? $instance['tags'] : 'Festivals, Rituals, Togetherness, Agriculture';
        $body     = ! empty( $instance['body'] ) ? $instance['body'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>"><?php esc_html_e( 'Subtitle:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'subtitle' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'subtitle' ) ); ?>" type="text" value="<?php echo esc_attr( $subtitle ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>"><?php esc_html_e( 'Tags (comma separated):', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tags' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tags' ) ); ?>" type="text" value="<?php echo esc_attr( $tags ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'body' ) ); ?>"><?php esc_html_e( 'Body Text:', 'newar-heritage' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'body' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'body' ) ); ?>" rows="5"><?php echo esc_textarea( $body ); ?></textarea>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['subtitle'] = sanitize_text_field( $new_instance['subtitle'] );
        $instance['tags']     = sanitize_text_field( $new_instance['tags'] );
        $instance['body']     = sanitize_textarea_field( $new_instance['body'] );
        return $instance;
    }
}

/* ==========================================================================
   STATS WIDGET
   ========================================================================== */

class Newar_Heritage_Stats_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'newar_heritage_stats',
            __( 'Home Stats Section', 'newar-heritage' ),
            array(
                'description' => __( 'Stats banner with heading and number cards. Note: Customizer settings take priority over this widget.', 'newar-heritage' ),
                'classname'   => 'newar-heritage-widget newar-heritage-stats-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Our Community Impact', 'newar-heritage' );
        $stats   = ! empty( $instance['stats'] ) ? $instance['stats'] : '';
        ?>
        <section class="stats-section" aria-labelledby="stats-heading">
            <div class="site-container">
                <h2 id="stats-heading" style="text-align: center; margin-bottom: var(--space-xl);">
                    <?php echo esc_html( $heading ); ?>
                </h2>

                <div class="stats-grid">
                    <?php if ( $stats ) : ?>
                        <?php $stat_items = explode( "\n", $stats ); ?>
                        <?php foreach ( $stat_items as $stat_item ) : ?>
                            <?php if ( trim( $stat_item ) ) : ?>
                                <?php
                                $parts = explode( '|', $stat_item );
                                $number = isset( $parts[0] ) ? trim( $parts[0] ) : '';
                                $label  = isset( $parts[1] ) ? trim( $parts[1] ) : '';
                                ?>
                                <div class="stat-card">
                                    <span class="stat-card__number"><?php echo esc_html( $number ); ?></span>
                                    <span class="stat-card__label"><?php echo esc_html( $label ); ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="stat-card"><span class="stat-card__number">70+</span><span class="stat-card__label"><?php esc_html_e( 'Years of Community Service', 'newar-heritage' ); ?></span></div>
                        <div class="stat-card"><span class="stat-card__number">250+</span><span class="stat-card__label"><?php esc_html_e( 'Guthis under the Samaj', 'newar-heritage' ); ?></span></div>
                        <div class="stat-card"><span class="stat-card__number">150+</span><span class="stat-card__label"><?php esc_html_e( 'Cultural Projects Completed', 'newar-heritage' ); ?></span></div>
                        <div class="stat-card"><span class="stat-card__number">5K+</span><span class="stat-card__label"><?php esc_html_e( 'Social Reach', 'newar-heritage' ); ?></span></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Our Community Impact', 'newar-heritage' );
        $stats   = ! empty( $instance['stats'] ) ? $instance['stats'] : "70+|Years of Community Service\n250+|Guthis under the Samaj\n150+|Cultural Projects Completed\n5K+|Social Reach";
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'stats' ) ); ?>"><?php esc_html_e( 'Stats (one per line, format: number|label):', 'newar-heritage' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'stats' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'stats' ) ); ?>" rows="6"><?php echo esc_textarea( $stats ); ?></textarea>
            <small><?php esc_html_e( 'Example:', 'newar-heritage' ); ?> 70+|Years of Community Service</small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['heading'] = sanitize_text_field( $new_instance['heading'] );
        $instance['stats']   = sanitize_textarea_field( $new_instance['stats'] );
        return $instance;
    }
}

/* ==========================================================================
   GALLERY WIDGET
   ========================================================================== */

class Newar_Heritage_Gallery_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'newar_heritage_gallery',
            __( 'Home Gallery Section', 'newar-heritage' ),
            array(
                'description' => __( 'Photo gallery grid with heading and images. Note: Customizer settings take priority over this widget.', 'newar-heritage' ),
                'classname'   => 'newar-heritage-widget newar-heritage-gallery-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Canvas of Our Heritage', 'newar-heritage' );
        $images  = ! empty( $instance['images'] ) ? $instance['images'] : '';
        ?>
        <section class="gallery-section" aria-labelledby="gallery-heading">
            <div class="site-container">
                <h2 id="gallery-heading">
                    <?php echo esc_html( $heading ); ?>
                </h2>

                <div class="gallery-grid">
                    <?php if ( $images ) : ?>
                        <?php $image_urls = explode( "\n", $images ); ?>
                        <?php foreach ( $image_urls as $image_url ) : ?>
                            <?php if ( trim( $image_url ) ) : ?>
                                <div class="gallery-grid__item">
                                    <img src="<?php echo esc_url( trim( $image_url ) ); ?>" alt="<?php echo esc_attr( $heading ); ?>" loading="lazy" />
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php for ( $i = 0; $i < 8; $i++ ) : ?>
                            <div class="gallery-grid__item">
                                <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/patterns/placeholder-photo.svg' ); ?>" alt="<?php esc_attr_e( 'Heritage photo placeholder', 'newar-heritage' ); ?>" loading="lazy" />
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Canvas of Our Heritage', 'newar-heritage' );
        $images  = ! empty( $instance['images'] ) ? $instance['images'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'images' ) ); ?>"><?php esc_html_e( 'Image URLs (one per line):', 'newar-heritage' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'images' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'images' ) ); ?>" rows="8"><?php echo esc_textarea( $images ); ?></textarea>
            <small><?php esc_html_e( 'Enter one image URL per line.', 'newar-heritage' ); ?></small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['heading'] = sanitize_text_field( $new_instance['heading'] );
        $instance['images']  = sanitize_textarea_field( $new_instance['images'] );
        return $instance;
    }
}

/* ==========================================================================
   HERITAGE CARDS WIDGET
   ========================================================================== */

class Newar_Heritage_Heritage_Cards_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'newar_heritage_heritage_cards',
            __( 'Home Heritage Cards', 'newar-heritage' ),
            array(
                'description' => __( 'Vertical cards list with title, description, and link. Note: Customizer settings take priority over this widget.', 'newar-heritage' ),
                'classname'   => 'newar-heritage-widget newar-heritage-heritage-cards-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Explore Our Heritage', 'newar-heritage' );
        $cards   = ! empty( $instance['cards'] ) ? $instance['cards'] : '';
        ?>
        <section class="cards-section" aria-labelledby="cards-heading">
            <div class="site-container">
                <h2 id="cards-heading">
                    <?php echo esc_html( $heading ); ?>
                </h2>

                <div class="cards-list">
                    <?php if ( $cards ) : ?>
                        <?php $card_items = explode( "\n", $cards ); ?>
                        <?php foreach ( $card_items as $card_item ) : ?>
                            <?php if ( trim( $card_item ) ) : ?>
                                <?php
                                $parts = explode( '|', $card_item );
                                $title       = isset( $parts[0] ) ? trim( $parts[0] ) : '';
                                $description = isset( $parts[1] ) ? trim( $parts[1] ) : '';
                                $link_text   = isset( $parts[2] ) ? trim( $parts[2] ) : __( 'More Info', 'newar-heritage' );
                                $link_url    = isset( $parts[3] ) ? trim( $parts[3] ) : '#';
                                ?>
                                <article class="card-item">
                                    <h3 class="card-item__title"><?php echo esc_html( $title ); ?></h3>
                                    <p class="card-item__desc"><?php echo esc_html( $description ); ?></p>
                                    <a href="<?php echo esc_url( $link_url ); ?>" class="card-item__link"><?php echo esc_html( $link_text ); ?></a>
                                </article>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <article class="card-item">
                            <h3 class="card-item__title"><?php esc_html_e( 'Deities & Temples', 'newar-heritage' ); ?></h3>
                            <p class="card-item__desc"><?php esc_html_e( 'Discover the living gods of the Kathmandu Valley — from the towering tales of Taleju to the intimate shrines of neighborhood guthis.', 'newar-heritage' ); ?></p>
                            <a href="#" class="card-item__link"><?php esc_html_e( 'More Info', 'newar-heritage' ); ?></a>
                        </article>
                        <article class="card-item">
                            <h3 class="card-item__title"><?php esc_html_e( 'Traditional Jewelry', 'newar-heritage' ); ?></h3>
                            <p class="card-item__desc"><?php esc_html_e( 'Explore the intricate gold and silver ornaments that have adorned Newari women for centuries — each piece a wearable heirloom.', 'newar-heritage' ); ?></p>
                            <a href="#" class="card-item__link"><?php esc_html_e( 'More Info', 'newar-heritage' ); ?></a>
                        </article>
                        <article class="card-item">
                            <h3 class="card-item__title"><?php esc_html_e( 'History & Legacy', 'newar-heritage' ); ?></h3>
                            <p class="card-item__desc"><?php esc_html_e( 'Trace the lineage of the Newar people — from the Licchavi era to the modern preservation efforts safeguarding our identity.', 'newar-heritage' ); ?></p>
                            <a href="#" class="card-item__link"><?php esc_html_e( 'More Info', 'newar-heritage' ); ?></a>
                        </article>
                        <article class="card-item">
                            <h3 class="card-item__title"><?php esc_html_e( 'Festivals & Calendar', 'newar-heritage' ); ?></h3>
                            <p class="card-item__desc"><?php esc_html_e( 'From Indra Jatra to Gai Jatra, experience the year-round cycle of celebrations that bind our community together.', 'newar-heritage' ); ?></p>
                            <a href="#" class="card-item__link"><?php esc_html_e( 'More Info', 'newar-heritage' ); ?></a>
                        </article>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $heading = ! empty( $instance['heading'] ) ? $instance['heading'] : __( 'Explore Our Heritage', 'newar-heritage' );
        $cards   = ! empty( $instance['cards'] ) ? $instance['cards'] : "Deities & Temples|Discover the living gods of the Kathmandu Valley — from the towering tales of Taleju to the intimate shrines of neighborhood guthis.|More Info|#\nTraditional Jewelry|Explore the intricate gold and silver ornaments that have adorned Newari women for centuries — each piece a wearable heirloom.|More Info|#\nHistory & Legacy|Trace the lineage of the Newar people — from the Licchavi era to the modern preservation efforts safeguarding our identity.|More Info|#\nFestivals & Calendar|From Indra Jatra to Gai Jatra, experience the year-round cycle of celebrations that bind our community together.|More Info|#";
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php esc_html_e( 'Heading:', 'newar-heritage' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cards' ) ); ?>"><?php esc_html_e( 'Cards (one per line, format: title|description|link_text|link_url):', 'newar-heritage' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cards' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cards' ) ); ?>" rows="10"><?php echo esc_textarea( $cards ); ?></textarea>
            <small><?php esc_html_e( 'Example:', 'newar-heritage' ); ?> Deities & Temples|Description text|More Info|https://example.com</small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['heading'] = sanitize_text_field( $new_instance['heading'] );
        $instance['cards']   = sanitize_textarea_field( $new_instance['cards'] );
        return $instance;
    }
}

/* ==========================================================================
   REGISTER WIDGETS
   ========================================================================== */

function newar_heritage_register_custom_widgets() {
    register_widget( 'Newar_Heritage_Hero_Widget' );
    register_widget( 'Newar_Heritage_Culture_Highlight_Widget' );
    register_widget( 'Newar_Heritage_Stats_Widget' );
    register_widget( 'Newar_Heritage_Gallery_Widget' );
    register_widget( 'Newar_Heritage_Heritage_Cards_Widget' );
}

add_action( 'widgets_init', 'newar_heritage_register_custom_widgets' );
