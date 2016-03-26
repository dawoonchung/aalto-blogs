<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12' ); ?>>
  <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>

  <?php
    the_content(
      sprintf( 'Continue reading...<span class="screen-reader-text"> "%s"</span>', get_the_title() )
    );

    // If a post is divided into pages
    wp_link_pages( array(
      'before'      => '<div class="page-links"><span class="page-links-title">' . 'Pages:' . '</span>',
      'after'       => '</div>',
      'link_before' => '<span>',
      'link_after'  => '</span>',
      'pagelink'    => '<span class="screen-reader-text">' . 'Page' . ' </span>%',
      'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
  ?>

  <aside class="entry-meta">
    <?php the_tags( '<div class="tag-list">', '', '</div>' ); ?>
    <?php aalto_blogs_entry_meta(); ?>
  </aside>

</article><!-- #post-## -->
