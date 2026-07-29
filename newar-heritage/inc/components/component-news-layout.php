<?php
/**
 * Component: News Layout
 *
 * Uses existing Customizer settings and WP_Query on `post`.
 * This keeps current Customizer-driven filtering intact while
 * centralizing the markup and empty-state handling.
 *
 * @param array $args
 * @param string $args['heading_mod']      Customizer setting for heading.
 * @param string $args['heading_default']  Fallback heading text.
 * @param string $args['post_count_mod']   Customizer setting for post count.
 * @param int    $args['post_count_default'] Fallback post count.
 * @param string $args['category_mod']     Customizer setting for category ID.
 */

$args = wp_parse_args(
    $args ?? array(),
    array(
        'heading_mod'         => 'newar_heritage_blog_heading',
        'heading_default'     => 'Latest Updates',
        'post_count_mod'      => 'newar_heritage_blog_post_count',
        'post_count_default'  => 3,
        'category_mod'        => 'newar_heritage_blog_category',
    )
);

$heading       = get_theme_mod( $args['heading_mod'], $args['heading_default'] );
$post_count    = max( 1, (int) get_theme_mod( $args['post_count_mod'], $args['post_count_default'] ) );
$category      = get_theme_mod( $args['category_mod'], '' );
?>

<section class="section" aria-labelledby="blog-heading">
    <div class="site-container">
        <h2 id="blog-heading"><?php echo esc_html( $heading ); ?></h2>
        <div class="blog-layout">
            <?php
            $blog_query = new WP_Query( array(
                'post_type'      => 'post',
                'posts_per_page' => $post_count,
                'cat'            => $category ? (int) $category : '',
                'post_status'    => 'publish',
                'no_found_rows'  => true,
            ) );

            if ( $blog_query->have_posts() ) :
                while ( $blog_query->have_posts() ) :
                    $blog_query->the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="btn">
                            <?php esc_html_e( 'Read More', 'newar-heritage' ); ?>
                        </a>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p><?php esc_html_e( 'No posts found.', 'newar-heritage' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
