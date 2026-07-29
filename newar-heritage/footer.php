<?php
/**
 * Footer template
 *
 * Dark maroon textured footer, 4-column layout:
 * Column 1: Logo + org name + description + social icons
 * Column 2: Quick Links
 * Column 3: More Links
 * Column 4: Contact
 */

$footer_data = array();

if ( ! defined( 'NEWAR_HERITAGE_FOOTER_DATA_LOADED' ) ) {
    $homepage_data = require get_stylesheet_directory() . '/inc/data/homepage.php';
    $footer_data   = ! empty( $homepage_data['footer'] ) ? $homepage_data['footer'] : array();
    define( 'NEWAR_HERITAGE_FOOTER_DATA_LOADED', true );
}
?>

</main>

<footer class="site-footer" role="contentinfo">
    <div class="site-container">

        <!-- Column 1: Brand + Description + Social -->
        <div class="footer-col footer-col__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <span class="footer-logo__emblem">
                        <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="2"/>
                            <circle cx="20" cy="20" r="14" fill="none" stroke="currentColor" stroke-width="1"/>
                            <polygon points="20,6 24,16 20,14 16,16" fill="currentColor"/>
                            <rect x="18" y="14" width="4" height="10" fill="currentColor"/>
                            <rect x="14" y="22" width="12" height="3" fill="currentColor"/>
                            <polygon points="20,25 16,30 24,30" fill="currentColor"/>
                        </svg>
                    </span>
                    <span class="footer-logo__name"><?php bloginfo( 'name' ); ?></span>
                <?php endif; ?>
            </a>
            <p class="footer-logo__tagline"><?php bloginfo( 'description' ); ?></p>

            <div class="site-footer__social-row" style="justify-content: flex-start; padding-top: 0; margin-top: var(--space-md); border-top: none;">
                <?php
                $socials = ! empty( $footer_data['socials'] ) ? $footer_data['socials'] : array(
                    array( 'platform' => 'Facebook', 'url' => function_exists( 'get_field' ) ? get_field( 'social_facebook', 'option' ) : '' ),
                    array( 'platform' => 'X / Twitter', 'url' => function_exists( 'get_field' ) ? get_field( 'social_twitter', 'option' ) : '' ),
                    array( 'platform' => 'Instagram', 'url' => function_exists( 'get_field' ) ? get_field( 'social_instagram', 'option' ) : '' ),
                    array( 'platform' => 'YouTube', 'url' => function_exists( 'get_field' ) ? get_field( 'social_youtube', 'option' ) : '' ),
                );

                foreach ( $socials as $social ) :
                    $url = ! empty( $social['url'] ) ? $social['url'] : '';
                    if ( ! $url ) {
                        continue;
                    }
                    $platform = ! empty( $social['platform'] ) ? $social['platform'] : '';
                    $label    = ! empty( $social['label'] ) ? $social['label'] : $platform;
                    $icon     = ! empty( $social['icon'] ) ? $social['icon'] : '';

                    if ( ! $icon ) {
                        if ( strpos( $url, 'facebook.com' ) !== false ) {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>';
                        } elseif ( strpos( $url, 'x.com' ) !== false || strpos( $url, 'twitter.com' ) !== false ) {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M4 4l6.5 8L4 20h1.8l5.2-6.2L16 20h4l-7-8.5L19.2 4H17.5l-4.5 5.2L10 4h4zm-2 16h2.4l8-9.8H15.5l-5.5 6.6L6 20h2z"/></svg>';
                        } elseif ( strpos( $url, 'instagram.com' ) !== false ) {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>';
                        } elseif ( strpos( $url, 'youtube.com' ) !== false ) {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" focusable="false"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.43z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48" fill="#fff"/></svg>';
                        } else {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><circle cx="12" cy="12" r="5"/></svg>';
                        }
                    }
                    ?>
                    <a href="<?php echo esc_url( $url ); ?>" class="social-icon" aria-label="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer">
                        <?php echo $icon; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div class="footer-col">
            <h3 class="footer-col__heading">Quick Links</h3>
            <ul class="footer-col__list">
                <?php
                $quick_links = ! empty( $footer_data['quickLinks'] ) ? $footer_data['quickLinks'] : array();
                if ( empty( $quick_links ) ) :
                    ?>
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/members' ) ); ?>">Members</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/guthibali' ) ); ?>">Guthibali</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/festivals' ) ); ?>">Festivals</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                <?php else : ?>
                    <?php foreach ( $quick_links as $link ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link['link'] ?? '#' ); ?>">
                                <?php echo esc_html( $link['label'] ?? '' ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Column 3: More Links -->
        <div class="footer-col">
            <h3 class="footer-col__heading">Discover</h3>
            <ul class="footer-col__list">
                <?php
                $branches = ! empty( $footer_data['branches'] ) ? $footer_data['branches'] : array();
                if ( empty( $branches ) ) :
                    ?>
                    <li><a href="<?php echo esc_url( home_url( '/culture' ) ); ?>">Culture</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/history' ) ); ?>">History</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/heritage' ) ); ?>">Heritage</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Contact</a></li>
                <?php else : ?>
                    <?php foreach ( $branches as $link ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link['link'] ?? '#' ); ?>">
                                <?php echo esc_html( $link['name'] ?? '' ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Column 4: Contact -->
        <div class="footer-col">
            <h3 class="footer-col__heading"><?php esc_html_e( 'Contact Us', 'newar-heritage' ); ?></h3>
            <?php
            if ( ! empty( $footer_data['contact'] ) ) {
                $contact = $footer_data['contact'];
            } else {
                $contact = array(
                    'address' => function_exists( 'get_field' ) ? get_field( 'contact_address', 'option' ) : '',
                    'phone'   => function_exists( 'get_field' ) ? get_field( 'contact_phone', 'option' ) : '',
                    'email'   => function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : '',
                );
            }
            ?>
            <?php if ( ! empty( $contact['address'] ) ) : ?>
                <p class="footer-col__text"><?php echo esc_html( $contact['address'] ); ?></p>
            <?php endif; ?>
            <?php if ( ! empty( $contact['phone'] ) ) : ?>
                <p class="footer-col__text">
                    <a href="tel:<?php echo esc_attr( $contact['phone'] ); ?>"><?php echo esc_html( $contact['phone'] ); ?></a>
                </p>
            <?php endif; ?>
            <?php if ( ! empty( $contact['email'] ) ) : ?>
                <p class="footer-col__text">
                    <a href="mailto:<?php echo esc_attr( $contact['email'] ); ?>"><?php echo esc_html( $contact['email'] ); ?></a>
                </p>
            <?php endif; ?>
        </div>

    </div>

    <!-- Bottom bar -->
    <div class="site-footer__bottom">
        <p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'newar-heritage' ); ?></p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
