<?php
/**
  * Official Aalto Blogs Theme functions and definitions
  *
  * @package WordPress
  * @subpackage Aalto_Blogs
  * @since Official Aalto Blogs Theme 1.0
  */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 * Can be overrided in child theme.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
if ( ! function_exists( 'aalto_blogs_setup' ) ) :
function aalto_blogs_setup() {
  register_nav_menus( array(
    'primary' => 'Primary Menu'
  ) );
}
endif; // aalto_blogs_setup
add_action( 'after_setup_theme', 'aalto_blogs_setup' );

/**
 * Enqueues scripts and styles.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_scripts() {
  // Theme stylesheet.
  wp_enqueue_style( 'aalto-blogs-style', get_stylesheet_uri() );

  // Load the html5 shiv.
  wp_enqueue_script( 'aalto-blogs-html5', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', array(), '3.7.2' );
  wp_script_add_data( 'aalto-blogs-html5', 'conditional', 'lt IE 9' );

  // Load respond.
  wp_enqueue_script( 'aalto-blogs-respond', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', array(), '1.4.2' );
  wp_script_add_data( 'aalto-blogs-respond', 'conditional', 'lt IE 9' );

  // Load Bootstrap scripts.
  wp_enqueue_script( 'aalto-blogs-bootstrap', get_template_directory_uri() . '/assets/js/vendor/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_scripts' );

/**
 * Other non-WordPress functions.
 *
 * @since Official Aalto Blogs Theme 0.1
 */
require get_template_directory() . '/inc/aalto-functions.php';

?>
