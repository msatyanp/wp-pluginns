<?php
/**
 * Block: Culture Highlight
 *
 * ACF block render template for the culture highlight section.
 *
 * Fields expected on options page:
 * - culture_title (text)
 * - culture_subtitle (textarea)
 * - culture_tags (repeater / text area)
 * - culture_body (textarea)
 */

$title    = ( function_exists( 'get_field' ) ? get_field( 'culture_title', 'option' ) : '' ) ?: 'Preserving Our Sacred Heritage';
$subtitle = ( function_exists( 'get_field' ) ? get_field( 'culture_subtitle', 'option' ) : '' ) ?: 'सांस्कृतिक सम्पदाको रक्षण';
$body     = ( function_exists( 'get_field' ) ? get_field( 'culture_body', 'option' ) : '' ) ?: '';
$tags     = ( function_exists( 'get_field' ) ? get_field( 'culture_tags', 'option' ) : '' );
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
            <?php if ( $tags && is_array( $tags ) ) : ?>
                <?php foreach ( $tags as $tag ) : ?>
                    <span class="culture-pill"><?php echo esc_html( $tag ); ?></span>
                <?php endforeach; ?>
            <?php else : ?>
                <span class="culture-pill"><?php esc_html_e( 'Festivals', 'newar-heritage' ); ?></span>
                <span class="culture-pill"><?php esc_html_e( 'Rituals', 'newar-heritage' ); ?></span>
                <span class="culture-pill"><?php esc_html_e( 'Togetherness', 'newar-heritage' ); ?></span>
                <span class="culture-pill"><?php esc_html_e( 'Agriculture', 'newar-heritage' ); ?></span>
            <?php endif; ?>
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
