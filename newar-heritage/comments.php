<?php
/**
 * Comments Template
 *
 * Displays comments and comment form.
 */

if ( post_password_required() ) {
    return;
}
?>

<section class="section section--white" aria-labelledby="comments-heading">
    <div class="site-container">
        <div class="blog-layout" style="max-width: 800px; margin: 0 auto;">

            <?php if ( have_comments() ) : ?>
                <h2 id="comments-heading" class="comments-title">
                    <?php
                    $comment_count = get_comments_number();
                    if ( '1' === $comment_count ) {
                        printf(
                            esc_html__( 'One thought on &ldquo;%s&rdquo;', 'newar-heritage' ),
                            '<span>' . get_the_title() . '</span>'
                        );
                    } else {
                        printf(
                            esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'newar-heritage' ) ),
                            number_format_i18n( $comment_count ),
                            '<span>' . get_the_title() . '</span>'
                        );
                    }
                    ?>
                </h2>

                <ol class="comment-list" style="list-style: none; padding: 0; margin: var(--space-xl) 0;">
                    <?php
                    wp_list_comments( array(
                        'style'       => 'ol',
                        'short_ping'  => true,
                        'avatar_size' => 48,
                    ) );
                    ?>
                </ol>

                <?php
                the_comments_navigation( array(
                    'prev_text' => __( '&larr; Older Comments', 'newar-heritage' ),
                    'next_text' => __( 'Newer Comments &rarr;', 'newar-heritage' ),
                ) );
                ?>

            <?php endif; ?>

            <?php
            if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
                ?>
                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'newar-heritage' ); ?></p>
            <?php endif; ?>

            <?php
            comment_form( array(
                'class_form'      => 'comment-form',
                'class_submit'    => 'btn',
                'title_reply'     => __( 'Leave a Reply', 'newar-heritage' ),
                'title_reply_to'  => __( 'Leave a Reply to %s', 'newar-heritage' ),
                'cancel_reply_link' => __( 'Cancel Reply', 'newar-heritage' ),
                'submit_button'   => '<input type="submit" name="%1$s" id="%2$s" class="%3$s" value="%4$s" />',
            ) );
            ?>

        </div>
    </div>
</section>
