<?php
/**
 * The template part for displaying content for single post and page
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12' ); ?>>
  <?php aalto_blogs_breadcrumbs(); ?>
  <?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>

  <?php
    the_content(
      sprintf( 'Continue reading...<span class="screen-reader-text"> "%s"</span>', get_the_title() )
    );

		if ( is_front_page() ) : ?>

		<p>You can also search for Aalto blogs and posts below.</p>
		<script>
			(function() {
				var cx = '013207120921188418786:4ce3un-vgj0';
				var gcse = document.createElement('script');
				gcse.type = 'text/javascript';
				gcse.async = true;
				gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(gcse, s);
			})();
		</script>
		<gcse:search></gcse:search>

		<?php endif;
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
		<div class="pull-left">
			<?php aalto_blogs_entry_meta(); ?>
		</div>
		<?php
			if ( function_exists( 'sharing_display' ) ) {
				sharing_display( '', true );
			}
		?>
  </aside>

</article><!-- #post-## -->
