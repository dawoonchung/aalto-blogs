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
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_setup() {
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  set_post_thumbnail_size( 746, 249, true );
  add_image_size( 'thumbnail-flex', 680, 9999 );
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
  $GLOBALS['content_width'] = apply_filters( 'aalto_blogs_content_width', 1140 );
}
add_action( 'after_setup_theme', 'aalto_blogs_content_width', 0 );


function aalto_blogs_widgets_init() {
  $checkGrid = get_theme_mod( 'front-layout' ) ?: 'list';
  $checkSingle = get_theme_mod( 'single-layout' ) ?: 'wide';
  $checkPage = get_theme_mod( 'page-layout' ) ?: 'wide';

  if ( $checkGrid != 'grid' || $checkSingle != 'wide' || $checkPage != 'wide' ) {
    register_sidebar( array(
      'name'          => 'Sidebar',
      'id'            => 'sidebar-1',
      'description'   => 'Add widgets here to appear in your sidebar.',
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h6 class="widget-title">',
      'after_title'   => '</h6>',
    ) );
  }
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
  wp_enqueue_script( 'aalto-blogs-bootstrap', get_template_directory_uri() . '/js/vendor/bootstrap.min.js', array( 'jquery' ), '3.3.6', true );

  if ( get_theme_mod( 'front-layout' ) === 'grid' ) {
    // Load Masonry script, only if grid layout is set in front page.
    wp_enqueue_script( 'aalto-blogs-masonry', get_template_directory_uri() . '/js/vendor/masonry.pkgd.min.js', array( 'jquery' ), '4.0.0', true );

    // Load ImagesLoaded script, only if grid layout is set in front page.
    wp_enqueue_script( 'aalto-blogs-imagesloaded', get_template_directory_uri() . '/js/vendor/imagesloaded.pkgd.min.js', array( 'jquery' ), '4.1.0', true );
  }

  // Load main script.
  wp_enqueue_script( 'aalto-blogs-slider-script', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '1.0', true );
  wp_enqueue_script( 'aalto-blogs-script', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Official Aalto Blogs Theme 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function aalto_blogs_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of active-sidebar to sites with active sidebar.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'active-sidebar';
	}

	// Adds a class to determine post layout.
  if ( get_theme_mod( 'single-layout' ) === 'narrow') {
    $classes[] = 'narrow-post';
  }
  else {
    $classes[] = 'wide-post';
  }

	// Adds a class to determine page layout.
  if ( get_theme_mod( 'page-layout' ) === 'narrow') {
    $classes[] = 'narrow-page';
  }
  else {
    $classes[] = 'wide-page';
  }

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'aalto_blogs_body_classes' );

/**
 * Load loop for JetPack Infinite Scroll.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_infinite_scroll_render() {
  $layout = get_theme_mod( 'front-layout' ) ?: 'list';
  get_template_part( 'template-parts/content', $layout . '-loop' );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Helper functions
 */
require get_template_directory() . '/inc/helper.php';

/**
 * Customiser features.
 */
require get_template_directory() . '/inc/customiser.php';

/**
 * Custom comment walker for display timestamp as 'time ago' format.
 */
require get_template_directory() . '/inc/comment-time-ago.php';

/**
 * Aalto specific functions.
 */
require get_template_directory() . '/inc/aalto-functions.php';

/**
 * Editor related functions.
 */
require get_template_directory() . '/inc/editor.php';

?>
