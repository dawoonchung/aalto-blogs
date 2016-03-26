<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

get_header(); ?>

  <div class="container">
    <div class="row">

    <?php $layout = get_theme_mod( 'front-layout' ) ?: 'list';
    if ( $layout === 'grid' ) : ?>

      <div id="primary" class="content-area col-xs-12">
        <main id="main" class="site-main row masonry-grid" role="main">

    <?php else : ?>

      <?php $offset = is_active_sidebar( 'sidebar-1' ) ? '' : 'col-md-offset-2'; ?>
      <div id="primary" class="content-area col-xs-12 col-md-8 <?php echo $offset; ?>">
        <main id="main" class="site-main row masonry-grid" role="main">

    <?php endif; ?>

          <div class="col-xs-12 col-sm-6 col-md-4 grid-width-init"></div>

          <?php if ( have_posts() ) :
            // Start the loop.
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content', $layout );
            // End the loop.
            endwhile; ?>

          <?php if ( $layout === 'grid' ) : ?>
            <div class="grid-item col-xs-12">
          <?php endif; ?>

          <?php
            the_posts_pagination( array(
              'prev_text'          => '&lt;',
              'next_text'          => '&gt;',
              'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>'
            ) );
          ?>

          <?php if ( $layout === 'grid' ) : ?>
            </div>
          <?php endif; ?>

          <?php
          // If no content, include the "No posts found" template.
          else :
            get_template_part( 'template-parts/content', 'none' );
          endif; ?>

        </main><!-- end .site-main -->
      </div><!-- end .content-area -->

      <?php if ( $layout != 'grid' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif; ?>
    </div><!-- end .row -->
  </div><!-- end .container -->

<?php get_footer(); ?>
