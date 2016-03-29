<?php     
/**     
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */ 
?>

  </div><!-- end .site-content -->

  <footer id="footer" class="site-footer">
    <div class="container">
			<div class="row">
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<div class="social-links">
							<nav class="social-navigation" role="navigation" aria-label="Footer Social Links Menu">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'social',
										'menu_class'     => 'social-links-menu list-unstyled',
										'depth'          => 1,
										'link_before'    => '<span class="screen-reader-text">',
										'link_after'     => '</span>',
									) );
								?>
							</nav>
					</div>
				<?php endif; ?>

				<div class="aalto-info">
          <a href="http://aalto.fi/en/" class="aalto-link" target="_blank"><?php generate_aalto_logo( aalto_blogs_rgba( get_theme_mod( 'footer_textcolor' ) ?: 'FFF', 0.9 ) ); ?></a>
					<p class="copyright">&copy; <?php bloginfo( 'name' ); ?> <?php echo current_time( 'Y' ); ?> </p>
					<p class="powered-by"><a href="http://blogs.aalto.fi" target="_blank">Aalto Blogs</a> service provided by <a href="https://into.aalto.fi/display/enit/Homepage" target="_blank">Aalto IT</a></p>
				</div>
			</div>
    </div>
  </footer>
</div><!-- end .site -->
<?php wp_footer(); ?>
</body>
</html>

