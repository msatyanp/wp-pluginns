<?php
get_header();
?>

<main id="primary" class="site-main">
<?php
while ( have_posts() ) :
    the_post();
    $post_id = get_the_ID();
    $first_name = function_exists( 'get_field' ) ? get_field( 'first_name', $post_id ) : '';
    $last_name  = function_exists( 'get_field' ) ? get_field( 'last_name', $post_id ) : '';
    $thar       = function_exists( 'get_field' ) ? get_field( 'thar', $post_id ) : '';
    $bio        = function_exists( 'get_field' ) ? get_field( 'bio', $post_id ) : '';
    $phone      = function_exists( 'get_field' ) ? get_field( 'phone_number', $post_id ) : '';
    $address    = function_exists( 'get_field' ) ? get_field( 'address', $post_id ) : '';
    $location   = function_exists( 'get_field' ) ? get_field( 'location', $post_id ) : '';
    $photo      = function_exists( 'get_field' ) ? get_field( 'member_photo', $post_id ) : '';
    $tier_terms = get_the_term_list( $post_id, 'member_tier', '', ', ', '' );
    $role_names = wp_get_post_terms( $post_id, 'member_role', array( 'fields' => 'names' ) );

    $full_name = trim( $first_name . ' ' . $last_name );
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'newar-member-detail' ); ?>>
        <header class="newar-member-detail__header">
            <?php if ( $photo ) : ?>
                <div class="newar-member-detail__photo">
                    <?php
                    if ( is_array( $photo ) && isset( $photo['url'] ) ) {
                        echo '<img src="' . esc_url( $photo['url'] ) . '" alt="' . esc_attr( $full_name ) . '" />';
                    } elseif ( is_numeric( $photo ) ) {
                        $url = wp_get_attachment_url( $photo );
                        if ( $url ) {
                            echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $full_name ) . '" />';
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="newar-member-detail__identity">
                <?php if ( $full_name ) : ?>
                    <h1 class="newar-member-detail__name"><?php echo esc_html( $full_name ); ?></h1>
                <?php endif; ?>

                <?php if ( $thar ) : ?>
                    <p class="newar-member-detail__thar"><?php echo esc_html( $thar ); ?></p>
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
                <section class="newar-member-detail__bio">
                    <h2><?php esc_html_e( 'Bio', 'newar-members' ); ?></h2>
                    <div><?php echo wp_kses_post( nl2br( $bio ) ); ?></div>
                </section>
            <?php endif; ?>

            <?php if ( $address ) : ?>
                <section class="newar-member-detail__address">
                    <h2><?php esc_html_e( 'Address', 'newar-members' ); ?></h2>
                    <p><?php echo esc_html( $address ); ?></p>
                </section>
            <?php endif; ?>

            <?php if ( is_user_logged_in() ) : ?>
                <?php if ( $phone ) : ?>
                    <section class="newar-member-detail__phone">
                        <h2><?php esc_html_e( 'Phone', 'newar-members' ); ?></h2>
                        <p><a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></p>
                    </section>
                <?php endif; ?>

                <?php if ( $location && is_array( $location ) && ! empty( $location['lat'] ) && ! empty( $location['lng'] ) ) : ?>
                    <section class="newar-member-detail__map">
                        <h2><?php esc_html_e( 'Location', 'newar-members' ); ?></h2>
                        <div class="newar-member-detail__map-container" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>" data-address="<?php echo esc_attr( isset( $location['address'] ) ? $location['address'] : '' ); ?>">
                            <a href="https://www.google.com/maps?q=<?php echo esc_attr( $location['lat'] ); ?>,<?php echo esc_attr( $location['lng'] ); ?>" target="_blank" rel="noopener noreferrer">
                                <?php esc_html_e( 'View on Google Maps', 'newar-members' ); ?>
                            </a>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </article>
<?php endwhile; ?>
</main>

<?php
get_footer();
