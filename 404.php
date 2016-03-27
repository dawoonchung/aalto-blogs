<?php
/**
 * Error 404 not found page.
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

get_header(); ?>

  <div class="container">
    <div class="row">
      <?php $offset = is_active_sidebar( 'sidebar-1' ) ? '' : 'col-md-offset-2'; ?>
      <div id="primary" class="content-area col-xs-12 col-md-8 <?php echo $offset; ?>">
        <main id="main" class="site-main row masonry-grid" role="main">
          <?php get_template_part( 'template-parts/content', 'none' ); ?>
        </main><!-- end .site-main -->
      </div><!-- end .content-area -->

      <?php if ( get_theme_mod( 'front_layout' ) != 'grid' || get_theme_mod( 'single_layout' ) != 'wide' || get_theme_mod( 'page_layout' ) != 'wide' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif; ?>
    </div><!-- end .row -->
  </div><!-- end .container -->

<?php get_footer(); ?>
