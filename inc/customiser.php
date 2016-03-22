<?php
/**
 * Aalto Blogs Customiser functionality
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Sets up the WordPress core custom header and custom background features.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_custom_header_and_background() {
//	$color_scheme             = twentysixteen_get_color_scheme();
//	$default_background_color = trim( $color_scheme[0], '#' );
//	$default_text_color       = trim( $color_scheme[3], '#' );

	/**
	 * Filter the arguments used when adding 'custom-background' support in Twenty Sixteen.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-background support arguments.
	 *
	 *     @type string $default-color Default color of the background.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'aalto_blogs_custom_background_args', array(
		'default-color' => '#EEE',
	) ) );

	/**
	 * Filter the arguments used when adding 'custom-header' support in Twenty Sixteen.
	 *
	 * @since Twenty Sixteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-text-color Default color of the header text.
	 *     @type int      $width            Width in pixels of the custom header image. Default 1200.
	 *     @type int      $height           Height in pixels of the custom header image. Default 280.
	 *     @type bool     $flex-height      Whether to allow flexible-height header images. Default true.
	 *     @type callable $wp-head-callback Callback function used to style the header image and text
	 *                                      displayed on the blog.
	 * }
	 */
    add_theme_support( 'custom-header', apply_filters( 'aalto_blogs_custom_header_args', array(
      'default-text-color'     => '#FFF',
      'width'                  => 1440,
      'flex-height'            => true,
  //		'wp-head-callback'       => 'aalto_blogs_header_style',
    ) ) );
}
add_action( 'after_setup_theme', 'aalto_blogs_custom_header_and_background' );

?>
