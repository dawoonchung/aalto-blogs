<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
?>

<div class="col-xs-12 col-sm-6 col-md-4 grid-item">
  <?php
    $grid_class = post_password_required() || is_attachment() || ( ! has_post_thumbnail() && ! get_the_first_attachment_for_post() ) ? 'no-thumbnail' : '';
  ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'col-xs-12 ' . $grid_class ); ?>>
      <?php aalto_blogs_post_thumbnail( 'thumbnail-flex' ); ?>
      <a href="<?php the_permalink(); ?>" rel="bookmark" class="grid-title-link">
        <?php if ( get_the_title() ) :
          the_title( '<h3 class="entry-title grid-title">', '</h3>' );
        else : ?>
          <h3 class="entry-title grid-title">(No Title)</h3>
        <?php endif; ?>
      </a>
  </article><!-- #post-## -->
</div>
