<?php
/**
 * The template for displaying pages
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
        <main id="main" class="site-main row" role="main">
					<?php while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', 'page' );

						 // If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
						  comments_template();
						}

					endwhile;
					?>

        </main><!-- end .site-main -->
      </div><!-- end .content-area -->

      <?php get_sidebar(); ?>
    </div><!-- end .row -->
  </div><!-- end .container -->

<?php get_footer(); ?>
