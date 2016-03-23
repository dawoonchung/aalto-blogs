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
    ) ) );
}
add_action( 'after_setup_theme', 'aalto_blogs_custom_header_and_background' );

function aalto_blogs_customize_register( $wp_customize ) {

  /**
   * Add opacity support for color picker.
   *
   * @url https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
   * @since Official Aalto Blogs Theme 1.0
   */
  require get_template_directory() . '/inc/alpha-color-picker.php';

  $wp_customize->remove_control( 'display_header_text' );
  $wp_customize->get_section( 'header_image' )->description = '<em>This setting will be ignored if you have a background image set.</em>';

  $wp_customize->get_section( 'colors' )->title = 'Layout Colours';
  $wp_customize->add_section( 'text_colors', array(
    'title'     => 'Text Colours',
    'priority'  => 50
  ) );

  $wp_customize->add_setting( 'header_background_color' );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_background_color', array(
    'label'       => 'Header Background',
    'section'     => 'colors',
    'priority'    => 1
  ) ) );

  $wp_customize->add_setting( 'header_menu_color' );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_menu_color', array(
    'label'       => 'Header Menu Background',
    'section'     => 'colors',
    'priority'    => 2
  ) ) );

  $wp_customize->get_control( 'background_color' )->label = 'Main Background';
  $wp_customize->get_control( 'background_color' )->description = 'This will be ignored if you have a background image set.';

  $wp_customize->add_setting( 'post_background_color', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'post_background_color', array(
    'label'   => 'Post Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->add_setting( 'footer_background_color', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'footer_background_color', array(
    'label'   => 'Footer Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->get_control( 'header_textcolor' )->section = 'text_colors';

  $wp_customize->add_setting( 'post_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'post_textcolor', array(
    'label'       => 'Post Text Colour',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'quote_color', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'quote_color', array(
    'label'       => 'Quotations Colour',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'link_color', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'link_color', array(
    'label'       => 'Links',
    'section'     => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'secondary_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'secondary_textcolor', array(
    'label'       => 'Secondary Texts',
    'section'     => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'body_textcolor', array() );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'body_textcolor', array(
    'label'       => 'Body Text Colour',
    'section'     => 'text_colors',
    'description' => 'Texts that are directly above main background'
  ) ) );

  $wp_customize->add_setting( 'footer_textcolor', array(
    'default' => ''
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_textcolor', array(
    'label'   => 'Footer Text Colour',
    'section' => 'text_colors'
  ) ) );
}
add_action( 'customize_register', 'aalto_blogs_customize_register', 11 );

?>
