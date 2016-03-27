<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<section class="no-results not-found col-xs-12" >
  <h3 class="entry-title">Nothing found.</h3>

  <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

    <p><?php printf( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

  <?php elseif ( is_search() ) : ?>

    <p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>
    <?php get_search_form(); ?>

  <?php else : ?>

    <p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>
    <?php get_search_form(); ?>

  <?php endif; ?>
</section>
