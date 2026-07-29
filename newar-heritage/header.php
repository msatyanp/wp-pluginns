<?php
/**
 * Header template
 *
 * Sticky dark maroon header with woven-pattern texture,
 * traditional gold border bottom, logo left, centered nav,
 * and gradient pill login button on right. Mobile hamburger.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'newar-heritage' ); ?></a>

<header class="site-header" role="banner">
    <div class="site-container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <span class="site-logo__emblem">
                    <?php the_custom_logo(); ?>
                </span>
            <?php else : ?>
                <span class="site-logo__emblem">
                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <circle cx="20" cy="20" r="18" fill="none" stroke="currentColor" stroke-width="2"/>
                        <circle cx="20" cy="20" r="14" fill="none" stroke="currentColor" stroke-width="1"/>
                        <polygon points="20,6 24,16 20,14 16,16" fill="currentColor"/>
                        <rect x="18" y="14" width="4" height="10" fill="currentColor"/>
                        <rect x="14" y="22" width="12" height="3" fill="currentColor"/>
                        <polygon points="20,25 16,30 24,30" fill="currentColor"/>
                    </svg>
                </span>
                <span class="site-logo__name"><?php bloginfo( 'name' ); ?></span>
            <?php endif; ?>
        </a>

        <button class="hamburger-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'newar-heritage' ); ?>" aria-expanded="false">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
        </button>

        <nav class="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'newar-heritage' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'primary-nav__list',
                    'fallback_cb'    => false,
                ) );
            } else {
                ?>
                <ul class="primary-nav__list">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'newar-heritage' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/members' ) ); ?>"><?php esc_html_e( 'Members', 'newar-heritage' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/guthibali' ) ); ?>"><?php esc_html_e( 'Guthibali', 'newar-heritage' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/festivals' ) ); ?>"><?php esc_html_e( 'Festivals', 'newar-heritage' ); ?></a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'newar-heritage' ); ?></a></li>
                </ul>
                <?php
            }
            ?>
        </nav>

        <a href="<?php echo esc_url( home_url( '/samaj-login' ) ); ?>" class="btn-samaj-login" aria-label="<?php esc_attr_e( 'Samaj Login', 'newar-heritage' ); ?>">
            <?php esc_html_e( 'Samaj Login', 'newar-heritage' ); ?>
        </a>
    </div>
</header>

<main id="main-content">
