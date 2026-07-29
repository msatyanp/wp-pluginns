<?php
/**
 * Block: Heritage Cards
 *
 * ACF block render template for vertical heritage cards.
 *
 * Fields expected on options page:
 * - cards_heading (text)
 * - heritage_cards (repeater with sub-fields: title, description, link_url, link_text)
 */

$heading = ( function_exists( 'get_field' ) ? get_field( 'cards_heading', 'option' ) : '' ) ?: 'Explore Our Heritage';
$cards   = ( function_exists( 'get_field' ) ? get_field( 'heritage_cards', 'option' ) : '' );
?>
<section class="cards-section" aria-labelledby="cards-heading">
    <div class="site-container">
        <h2 id="cards-heading">
            <?php echo esc_html( $heading ); ?>
        </h2>

        <div class="cards-list">
            <?php if ( $cards && is_array( $cards ) ) : ?>
                <?php foreach ( $cards as $card ) : ?>
                    <article class="card-item">
                        <h3 class="card-item__title"><?php echo esc_html( $card['title'] ); ?></h3>
                        <p class="card-item__desc"><?php echo esc_html( $card['description'] ); ?></p>
                        <a href="<?php echo esc_url( $card['link_url'] ?: '#' ); ?>" class="card-item__link"><?php echo esc_html( $card['link_text'] ?: 'More Info' ); ?></a>
                    </article>
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
