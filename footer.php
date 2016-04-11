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
          <?php
            global $symbol;

            if ( get_theme_mod( 'footer_logo_color' ) == 'black' ) {
              $logo_color = '000';
            }
            else {
              $logo_color = 'FFF';
            }
          ?>
          <a href="http://aalto.fi/en/" class="aalto-link aalto-link-full aalto-link-<?php echo $symbol; ?>" target="_blank"><?php generate_aalto_logo( '#' . $logo_color, true ); ?></a>
				</div>
			</div>
    </div>
  </footer>
</div><!-- end .site -->
<?php wp_footer(); ?>
</body>
</html>

