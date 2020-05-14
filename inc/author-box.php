<?php
/**
 * Dispay author bio and other information on single posts and author index page.
 * Dependent on bio being available for current author.
 *
 * @package PipTheme
 */
?>

<div class="reveal-bio">
    <?php echo '<a href="#" class="fa fa-minus-circle" title="' . __('Hide Author Bio', 'piptheme') . '"><span class="screen-reader-text">' . __('Hide Author Bio', 'piptheme') . '</span></a>'; ?>
</div>

<div class="author-info">

    <div class="author-avatar">
            <?php
            echo get_avatar( get_the_author_meta( 'user_email' ), 96 );
            ?>
    </div><!-- .author-avatar -->
    <div class="author-meta">
        <h2 class="author-title"><?php printf( __( 'About %s', 'piptheme' ), get_the_author() ); ?></h2>
        <div class="share-and-more">
            <?php
            // Change language depending on number of posts
            $posts_posted = get_the_author_posts();
            if ( $posts_posted == 1) { 
                printf(
                        /* translators: May be followed by another sentence. There is a space after the punctuation mark.  */
                        __( 'One article and counting. ', 'piptheme' ) ); 
            }
            else { 
                printf(
                    /* translators: May be followed by another sentence. There is a space after the punctuation mark.  */
                    __( '%s articles and counting. ', 'piptheme' ), the_author_posts() ); 
            }
            $author_firstname = get_the_author_meta('first_name');
            // Check if social media info is collected in user profile
            // Usually handled by a plugin like WordPress SEO by Yoast
            $author_twitter = get_the_author_meta('twitter');
            $author_facebook = get_the_author_meta('facebook');
            if ( $author_twitter || $author_facebook ) {
                echo '<div class="author-social-media">';
                printf(__( 'Follow %s on social media: ', 'piptheme' ), get_the_author_meta('first_name') );
                if ( $author_twitter ) {
                	echo '<a href="https://twitter.com/' . esc_attr( $author_twitter ) . '" title="' . sprintf( __( 'Follow %s on Twitter', 'piptheme' ), $author_firstname ) . '"  target="_blank"><i class="fa fa-twitter"></i><span class="screen-reader-text">' . __( 'Twitter', 'piptheme' ) . '</span></a>';
                }
                if ( $author_facebook ) {
                	echo '<a href="' . esc_url( $author_facebook ) . '" title="' .  sprintf( __( 'Like %s on Facebook', 'piptheme' ), $author_firstname ) . '"  target="_blank"><i class="fa fa-facebook"></i><span class="screen-reader-text">' . __( 'Facebook', 'piptheme' ) . '</span></a>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="author-description">

            <p class="author-bio">
                <?php the_author_meta( 'description' )  ?>
            </p>
            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
            <?php printf( __( 'All posts by %s', 'piptheme' ), get_the_author_meta('first_name') . ' <i class="fa fa-arrow-circle-o-right"></i>' ); ?>
        </a>
    </div><!-- .author-description -->
</div><!-- .author-info -->