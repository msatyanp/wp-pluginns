<?php
/**
 * Single Member Detail Template (fallback for themes without their own).
 *
 * Used via template_include filter when the active theme does not
 * provide a single-member.php template.
 *
 * @package NewarMembers
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main newar-member-detail">
    <?php
    while ( have_posts() ) :
        the_post();
        $post_id = get_the_ID();
        $first_name = get_post_meta( $post_id, 'first_name', true );
        $last_name  = get_post_meta( $post_id, 'last_name', true );
        $bio        = get_post_meta( $post_id, 'bio', true );
        $phone      = get_post_meta( $post_id, 'phone_number', true );
        $address    = get_post_meta( $post_id, 'address', true );
        $location   = get_post_meta( $post_id, 'location', true );
        $photo      = get_post_meta( $post_id, 'member_photo', true );
        $tier_terms = get_the_term_list( $post_id, 'member_tier', '', ', ', '' );
        $role_names = wp_get_post_terms( $post_id, 'member_role', array( 'fields' => 'names' ) );

        $full_name = trim( $first_name . ' ' . $last_name );

        // Determine back link based on tier.
        $back_url   = home_url( '/members/' );
        $back_label = __( 'Back to Members', 'newar-members' );
        $tier_slugs = wp_get_post_terms( $post_id, 'member_tier', array( 'fields' => 'slugs' ) );
        if ( ! is_wp_error( $tier_slugs ) && ! empty( $tier_slugs ) ) {
            $first_slug = $tier_slugs[0];
            $tier_pages = array(
                'committee'  => 'committee',
                'leadership' => 'leadership',
                'general_member' => 'members',
            );
            if ( isset( $tier_pages[ $first_slug ] ) ) {
                $back_url   = home_url( '/' . $tier_pages[ $first_slug ] . '/' );
                $back_label = sprintf( __( 'Back to %s', 'newar-members' ), ucwords( str_replace( '_', ' ', $first_slug ) ) );
            }
        }
        ?>
        <a class="newar-member-detail__back" href="<?php echo esc_url( $back_url ); ?>">
            &larr; <?php echo esc_html( $back_label ); ?>
        </a>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'newar-member-detail' ); ?>>
            <header class="newar-member-detail__header">
                <div class="newar-member-detail__photo">
                    <?php echo newar_member_avatar( $post_id, 'large' ); ?>
                </div>

                <div class="newar-member-detail__identity">
                    <?php if ( $full_name ) : ?>
                        <h1 class="newar-member-detail__name"><?php echo esc_html( $full_name ); ?></h1>
                    <?php endif; ?>

                    <?php if ( ! empty( $role_names ) && ! is_wp_error( $role_names ) ) : ?>
                        <p class="newar-member-detail__role">
                            <?php echo esc_html( implode( ', ', $role_names ) ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $tier_terms ) : ?>
                        <p class="newar-member-detail__tier"><?php echo $tier_terms; ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <div class="newar-member-detail__body">
                <?php if ( $bio ) : ?>
                    <section class="newar-member-detail__section newar-member-detail__section--highlight">
                        <h2><?php esc_html_e( 'Bio', 'newar-members' ); ?></h2>
                        <div><?php echo wp_kses_post( nl2br( $bio ) ); ?></div>
                    </section>
                <?php endif; ?>

                <?php if ( $address ) : ?>
                    <section class="newar-member-detail__section">
                        <h2><?php esc_html_e( 'Address', 'newar-members' ); ?></h2>
                        <div class="newar-member-detail__address">
                            <div class="newar-member-detail__address-icon" aria-hidden="true">📍</div>
                            <p><?php echo esc_html( $address ); ?></p>
                        </div>
                    </section>
                <?php endif; ?>

                <?php if ( is_user_logged_in() ) : ?>
                    <?php if ( $phone ) : ?>
                        <section class="newar-member-detail__section">
                            <h2><?php esc_html_e( 'Phone', 'newar-members' ); ?></h2>
                            <div class="newar-member-detail__address">
                                <div class="newar-member-detail__address-icon" aria-hidden="true">📞</div>
                                <p><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></p>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if ( $location && is_array( $location ) && ! empty( $location['lat'] ) && ! empty( $location['lng'] ) ) : ?>
                        <section class="newar-member-detail__section">
                            <h2><?php esc_html_e( 'Location', 'newar-members' ); ?></h2>
                            <div class="newar-member-detail__map-container"
                                 data-lat="<?php echo esc_attr( $location['lat'] ); ?>"
                                 data-lng="<?php echo esc_attr( $location['lng'] ); ?>"
                                 data-address="<?php echo esc_attr( isset( $location['address'] ) ? $location['address'] : '' ); ?>">
                                <a href="https://www.google.com/maps?q=<?php echo esc_attr( $location['lat'] ); ?>,<?php echo esc_attr( $location['lng'] ); ?>"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    📍 <?php esc_html_e( 'View on Google Maps', 'newar-members' ); ?>
                                </a>
                                <p class="newar-member-detail__map-hint"><?php esc_html_e( 'Opens in Google Maps for directions.', 'newar-members' ); ?></p>
                            </div>
                        </section>
                    <?php endif; ?>
                <?php else : ?>
                    <section class="newar-member-detail__section">
                        <h2><?php esc_html_e( 'Contact Information', 'newar-members' ); ?></h2>
                        <p class="newar-member-detail__map-hint"><?php esc_html_e( 'Phone and location details are only visible to logged-in members.', 'newar-members' ); ?></p>
                    </section>
                <?php endif; ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_footer();
