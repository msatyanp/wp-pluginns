<?php
/**
 * Block: Stats Section
 *
 * ACF block render template for stats banner.
 *
 * Fields expected on options page:
 * - stats_heading (text)
 * - home_stats (repeater with sub-fields: number, label)
 */

$heading = ( function_exists( 'get_field' ) ? get_field( 'stats_heading', 'option' ) : '' ) ?: 'Our Community Impact';
$stats   = ( function_exists( 'get_field' ) ? get_field( 'home_stats', 'option' ) : '' );
?>
<section class="stats-section" aria-labelledby="stats-heading">
    <div class="site-container">
        <h2 id="stats-heading" style="text-align: center; margin-bottom: var(--space-xl);">
            <?php echo esc_html( $heading ); ?>
        </h2>

        <div class="stats-grid">
            <?php if ( $stats && is_array( $stats ) ) : ?>
                <?php foreach ( $stats as $stat ) : ?>
                    <div class="stat-card">
                        <span class="stat-card__number"><?php echo esc_html( $stat['number'] ); ?></span>
                        <span class="stat-card__label"><?php echo esc_html( $stat['label'] ); ?></span>
                    </div>
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
