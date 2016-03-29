<?php     
/**     
 * The template for displaying the sidebar
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */ 
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
  <div class="col-xs-12 col-md-4 sidebar">
    <aside id="secondary" class="sidebar-area widget-area" role="complementary">
     <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- .sidebar .widget-area -->
  </div>
<?php endif; ?>
