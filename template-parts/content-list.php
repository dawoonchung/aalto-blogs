<?php
/**
 * The template part for displaying content in list layout
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12 article-list' ); ?>>
  <?php if ( is_sticky() ) : ?>
    <span class="is-sticky"></span>
  <?php endif; ?>
  <aside class="entry-meta">
    <?php aalto_blogs_entry_meta(); ?>
  </aside>

  <?php aalto_blogs_post_thumbnail(); ?>

  <?php $excerpt_class = has_excerpt() ? 'has-excerpt' : ''; ?>
  <a href="<?php the_permalink(); ?>" rel="bookmark" class="link-excerpt <?php echo $excerpt_class; ?>">
    <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
    <div class="excerpt-content"><?php aalto_blogs_excerpt(); ?></div>
  </a>

  <?php if ( get_comments_number() ) :
  $comment_class = ( 1 == get_comments_number() ) ? '' : 'multiple'; ?>
    <span class="comment-count <?php echo $comment_class; ?>">
      <?php echo get_comments_number(); ?>
    </span>
  <?php endif; ?>

  <a href="<?php the_permalink(); ?>" class="more-link"><p>Continue reading...<span class="screen-reader-text"><?php the_title(); ?></span></p></a>
</article><!-- #post-## -->
