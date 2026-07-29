<?php
/**
 * Component: Footer
 *
 * @param array $args
 * @param array $args['footer'] Footer data array from inc/data/homepage.php.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'footer' => array(),
    )
);

$footer = $args['footer'];

$contact  = ! empty( $footer['contact'] ) ? $footer['contact'] : array();
$branches = ! empty( $footer['branches'] ) ? $footer['branches'] : array();
$quick    = ! empty( $footer['quickLinks'] ) ? $footer['quickLinks'] : array();
$socials  = ! empty( $footer['socials'] ) ? $footer['socials'] : array();
?>

<footer class="site-footer" role="contentinfo">
    <div class="site-container">
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

            <?php if ( ! empty( $socials ) ) : ?>
                <div class="site-footer__social-row">
                    <?php foreach ( $socials as $social ) :
                        $url = ! empty( $social['url'] ) ? $social['url'] : '';
                        if ( ! $url ) {
                            continue;
                        }
                        $platform = ! empty( $social['platform'] ) ? $social['platform'] : '';
                        $label    = ! empty( $social['label'] ) ? $social['label'] : $platform;
                        $icon     = ! empty( $social['icon'] ) ? $social['icon'] : '';
                        if ( ! $icon ) {
                            $icon = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><circle cx="12" cy="12" r="5"/></svg>';
                        }
                        ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="social-icon" aria-label="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo wp_kses_post( $icon ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $quick ) ) : ?>
            <div class="footer-col">
                <h3 class="footer-col__heading"><?php esc_html_e( 'Quick Links', 'newar-heritage' ); ?></h3>
                <ul class="footer-col__list">
                    <?php foreach ( $quick as $link ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link['link'] ?? '#' ); ?>">
                                <?php echo esc_html( $link['label'] ?? '' ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $branches ) ) : ?>
            <div class="footer-col">
                <h3 class="footer-col__heading"><?php esc_html_e( 'Discover', 'newar-heritage' ); ?></h3>
                <ul class="footer-col__list">
                    <?php foreach ( $branches as $link ) : ?>
                        <li>
                            <a href="<?php echo esc_url( $link['link'] ?? '#' ); ?>">
                                <?php echo esc_html( $link['name'] ?? '' ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ( ! empty( $contact ) ) : ?>
            <div class="footer-col">
                <h3 class="footer-col__heading"><?php esc_html_e( 'Contact Us', 'newar-heritage' ); ?></h3>
                <?php if ( ! empty( $contact['address'] ) ) : ?>
                    <p class="footer-col__text"><?php echo esc_html( $contact['address'] ); ?></p>
                <?php endif; ?>
                <?php if ( ! empty( $contact['phone'] ) ) : ?>
                    <p class="footer-col__text">
                        <a href="tel:<?php echo esc_attr( $contact['phone'] ); ?>">
                            <?php echo esc_html( $contact['phone'] ); ?>
                        </a>
                    </p>
                <?php endif; ?>
                <?php if ( ! empty( $contact['email'] ) ) : ?>
                    <p class="footer-col__text">
                        <a href="mailto:<?php echo esc_attr( $contact['email'] ); ?>">
                            <?php echo esc_html( $contact['email'] ); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="site-footer__bottom">
        <p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'newar-heritage' ); ?></p>
    </div>
</footer>
