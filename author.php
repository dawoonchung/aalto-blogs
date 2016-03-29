<?php
/**
 * The template for displaying the author
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
          <article id="about-author" <?php post_class( 'col-xs-12 article-list' ); ?>>
            <figure class="author-avatar">
              <?php
                $author_avatar_size = apply_filters( 'aalto_blogs_author_avatar_size', 80 );
                echo get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size );
              ?>
            </figure>

            <?php if ( get_the_author_meta( 'url' ) ) : ?>
            <h3 class="author-name has-website">
            <?php else : ?>
            <h3 class="author-name">
            <?php endif; ?>
              <?php the_author() ?>
            </h3>

            <?php if ( get_the_author_meta( 'url' ) ) : ?>
              <p class="author-website"><a href="<?php the_author_meta( 'url' ); ?>" target="_blank"><?php the_author_meta( 'url' ); ?></a></p>
            <?php endif; ?>

            <?php if ( get_the_author_meta( 'description' ) ) : ?>
              <p class="author-biography"><?php the_author_meta( 'description' ); ?></p>

            <?php else : ?>
              <?php if ( get_current_user_id() == get_the_author_meta( 'ID' ) ) : ?>
                <p class="no-author-info is-my-profile">You haven't entered your biographical information. <a href="<?php echo get_edit_user_link(); ?>">Let's promote yourself!</a></p>
              <?php else : ?>
                <p class="no-author-info">Author has not shared any biographical information.</p>
              <?php endif; ?>
            <?php endif; ?>
          </article><!-- #post-## -->

          <hr class="section-separator col-xs-2 col-xs-offset-5" />

          <?php if ( have_posts() ) : ?>

          <h6 class="author-section-title col-xs-12">Posts by this author</h6>

          <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/content', 'list' );
            // End the loop.
            endwhile; ?>

          <?php
            the_posts_pagination( array(
              'prev_text'          => '&lt;',
              'next_text'          => '&gt;',
              'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>'
            ) );
          ?>
          <?php
          // If no content, include the "No posts found" template.
          else : ?>

          <h6 class="author-section-title col-xs-12">This author has not published any posts yet.</h6>

          <?php endif; ?>

        </main><!-- end .site-main -->
      </div><!-- end .content-area -->

      <?php if ( get_theme_mod( 'front_layout' ) != 'grid' || get_theme_mod( 'single_layout' ) != 'wide' || get_theme_mod( 'page_layout' ) != 'wide' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif; ?>
    </div><!-- end .row -->
  </div><!-- end .container -->

<?php get_footer(); ?>
