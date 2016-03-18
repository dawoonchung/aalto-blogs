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
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 746, 249, true );
  register_nav_menus( array( 
    'primary' => 'Header Menu',
    'social' => 'Social Links'
  ) );
	add_theme_support( 'html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ) );
}
endif; // aalto_blogs_setup
add_action( 'after_setup_theme', 'aalto_blogs_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_content_width() {
  $GLOBALS['content_width'] = apply_filters( 'aalto_blogs_content_width', 788 );
}
add_action( 'after_setup_theme', 'aalto_blogs_content_width', 0 );

function aalto_blogs_widgets_init() {
  register_sidebar( array(
    'name'          => 'Sidebar',
    'id'            => 'sidebar-1',
    'description'   => 'Add widgets here to appear in your sidebar.',
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'aalto_blogs_widgets_init' );

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
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Aalto Specific functions.
 */
require get_template_directory() . '/inc/aalto-functions.php';

?>
