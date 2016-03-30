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
	add_theme_support( 'custom-background', apply_filters( 'aalto_blogs_custom_background_args', array(
		'default-color'      => '#EEE',
    'default-repeat'     => 'no-repeat',
    'default-position-x' => 'center',
    'default-attachment' => 'fixed'
	) ) );
  add_theme_support( 'custom-header', apply_filters( 'aalto_blogs_custom_header_args', array(
    'default-text-color'     => 'FFF',
    'width'                  => 1440,
    'height'                 => 400,
    'flex-height'            => true,
    'wp-head-callback'       => 'aalto_blogs_header_style'
  ) ) );
}
add_action( 'after_setup_theme', 'aalto_blogs_custom_header_and_background' );

/**
 * Sets up customiser API.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_customize_register( $wp_customize ) {
  /**
   * Add opacity support for color picker.
   *
   * @url https://github.com/BraadMartin/components/tree/master/customizer/alpha-color-picker
   * @since Official Aalto Blogs Theme 1.0
   */
  require_once get_template_directory() . '/inc/alpha-color-picker.php';

  $wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

  $wp_customize->remove_control( 'display_header_text' );

  $wp_customize->remove_control( 'background_repeat' );
  $wp_customize->remove_control( 'background_position_x' );
  $wp_customize->remove_control( 'background_attachment' );

  $wp_customize->get_section( 'colors' )->title = 'Layout Colours';
  $wp_customize->add_section( 'text_colors', array(
    'title'     => 'Text Colours',
    'priority'  => 50
  ) );

  $wp_customize->add_section( 'layout_style', array(
    'title'    => 'Site Layout',
    'priority' => 20,
  ) );

  $wp_customize->add_setting( 'front_layout', array(
    'default'           => 'list',
    'sanitize_callback' => 'aalto_blogs_sanitize_front'
  ) );
  $wp_customize->add_control( 'front_layout', array(
    'label'       => 'Front Page Layout',
    'section'     => 'layout_style',
    'type'        => 'radio',
    'description' => 'In Safari, images may not display correctly in preview screen for Grid layout. (Does not affect actual layout)',
    'choices'     => array(
      'list'     => 'List (text-based)',
      'grid'     => 'Grid (image-based)'
    )
  ) );

  $wp_customize->add_setting( 'single_layout', array(
    'default'           => 'wide',
    'sanitize_callback' => 'aalto_blogs_sanitize_layout'
  ) );
  $wp_customize->add_control( 'single_layout', array(
    'label'   => 'Single Post Layout',
    'section' => 'layout_style',
    'type'    => 'radio',
    'choices' => array(
      'wide'     => 'Wide',
      'narrow'   => 'Narrow'
    )
  ) );

  $wp_customize->add_setting( 'page_layout', array(
    'default'           => 'wide',
    'sanitize_callback' => 'aalto_blogs_sanitize_layout'
  ) );
  $wp_customize->add_control( 'page_layout', array(
    'label'   => 'Page Layout',
    'section' => 'layout_style',
    'type'    => 'radio',
    'choices' => array(
      'wide'     => 'Wide',
      'narrow'   => 'Narrow'
    )
  ) );

  $wp_customize->add_setting( 'breadcrumbs', array(
    'sanitize_callback' => 'aalto_blogs_sanitize_checkbox'
  ) );
  $wp_customize->add_control( 'breadcrumbs', array(
    'label'       => 'Show Breadcrumb',
    'description' => '(For single post and page)',
    'section'     => 'layout_style',
    'type'        => 'checkbox'
  ) );

  $wp_customize->add_setting( 'header_background_color', array(
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    'transport'         => 'postMessage'
  ) );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_background_color', array(
    'label'       => 'Header Background',
    'section'     => 'colors',
    'description' => 'This will be ignored if you have a header image set.',
    'priority'    => 1
  ) ) );

  $wp_customize->add_setting( 'header_menu_color', array(
    'default'           => 'rgba(0,0,0,0.5)',
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    'transport'         => 'postMessage'
  ) );
  $wp_customize->add_control(new Customize_Alpha_Color_Control( $wp_customize, 'header_menu_color', array(
    'label'    => 'Header Menu Background',
    'section'  => 'colors',
    'priority' => 2
  ) ) );

  $wp_customize->get_control( 'background_color' )->label = 'Main Background';
  $wp_customize->get_control( 'background_color' )->description = 'This will be ignored if you have a background image set.';

  $wp_customize->add_setting( 'post_background_color', array(
    'default'           => 'rgba(255,255,255,0.8)',
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    'transport'         => 'postMessage'
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'post_background_color', array(
    'label'   => 'Post Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->add_setting( 'grid_background_color', array(
    'default'           => 'rgba(255,255,255,0.9)',
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    'transport'         => 'postMessage'
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'grid_background_color', array(
    'label'       => 'Grid Background',
    'section'     => 'colors',
    'description' => 'Used only if grid layout is selected.'
  ) ) );

  $wp_customize->add_setting( 'grid_hover_color', array(
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    // 'transport'         => 'postMessage'
    // jQuery cannot handle hover state, so use refresh.
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'grid_hover_color', array(
    'label'       => 'Grid Mouse Over',
    'section'     => 'colors',
    'description' => 'Used only if grid layout is selected.'
  ) ) );

  $wp_customize->add_setting( 'footer_background_color', array(
    'sanitize_callback' => 'aalto_blogs_sanitize_rgba',
    'transport'         => 'postMessage'
  ) );
  $wp_customize->add_control( new Customize_Alpha_Color_Control( $wp_customize, 'footer_background_color', array(
    'label'   => 'Footer Background',
    'section' => 'colors'
  ) ) );

  $wp_customize->get_control( 'header_textcolor' )->section = 'text_colors';

  $wp_customize->add_setting( 'header_menu_textcolor', array(
    'default'           => '#FFF',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'header_menu_textcolor', array(
    'label'   => 'Header Menu Text Colour',
    'section' => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'post_textcolor', array(
    'default'           => '#333',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'post_textcolor', array(
    'label'   => 'Post Text Colour',
    'section' => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'quote_color', array(
    'default'           => '#8C857B',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'quote_color', array(
    'label'   => 'Blockquote Colour',
    'section' => 'text_colors',
  ) ) );

  $wp_customize->add_setting( 'link_color', array(
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'link_color', array(
    'label'   => 'Links',
    'section' => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'secondary_textcolor', array(
    'default'           => '#8C857B',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'secondary_textcolor', array(
    'label'       => 'Secondary Texts',
    'description' => 'Also used for table border colour.',
    'section'     => 'text_colors'
  ) ) );

  $wp_customize->add_setting( 'body_textcolor', array(
    'default'           => '#333',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_color_Control( $wp_customize, 'body_textcolor', array(
    'label'       => 'Body Text Colour',
    'section'     => 'text_colors',
    'description' => 'Texts that are directly above main background.',
  ) ) );

  $wp_customize->add_setting( 'grid_textcolor', array(
    'default'           => '#FFF',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'grid_textcolor', array(
    'label'       => 'Grid Title',
    'section'     => 'text_colors',
    'description' => 'Used only if grid layout is selected.'
  ) ) );

  $wp_customize->add_setting( 'footer_textcolor', array(
    'default'           => '#FFF',
    'sanitize_callback' => 'sanitize_hex_color'
  ) );
  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_textcolor', array(
    'label'   => 'Footer Text Colour',
    'section' => 'text_colors',
  ) ) );
}
add_action( 'customize_register', 'aalto_blogs_customize_register', 11 );

/**
 * Sanitize Front Layout
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_sanitize_front( $value ) {
  $option = array( 'list', 'grid' );

  if ( ! in_array ( $value, $option ) ) {
    $value = 'list';
  }

  return $value;
}

/**
 * Sanitize Single Layout
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_sanitize_layout( $value ) {
  $option = array( 'wide', 'narrow' );

  if ( ! in_array ( $value, $option ) ) {
    $value = 'wide';
  }

  return $value;
}

/**
 * Sanitize Checkbox
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_sanitize_checkbox( $value ) {
  $value = (int) $value;

  return $value;
}

/**
 * Sanitize RGBA
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_sanitize_rgba( $value ) {
  if ( substr( $value, 0, 1 ) === '#' ) {
    $value = sanitize_hex_color( $value );
    return $value;
  }
  else if ( substr( $value, 0, 4 ) === 'rgba' ) {
    return $value;
  }
  else {
    $value = sanitize_hex_color_no_hash( $value );
    return $value;
  }
}

/**
 * Applies custom header style.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_header_style() {
  global $aalto_colour;

  $header_textcolor = '#' . ( get_header_textcolor() ?: 'FFF' );
  $header_background = get_theme_mod( 'header_background_color' ) ?: $aalto_colour;
  $header_menu_background = get_theme_mod( 'header_menu_color' ) ?: 'rgba(0,0,0,0.5)';
  $header_menu_textcolor = get_theme_mod( 'header_menu_textcolor' ) ?: '#FFF';
?>
<style>
  .site-header {
    color: <?php echo $header_textcolor ?>;
    <?php if ( get_header_image() ) : ?>
      background-image: url(' <?php echo get_header_image(); ?>' );
    <?php else : ?>
      background-color: <?php echo $header_background; ?>;
    <?php endif; ?>
  }

  .icon-bar {
    background: <?php echo $header_textcolor; ?>;
  }
  .site-header-menu {
    background-color: <?php echo $header_menu_background; ?>;
    color: <?php echo $header_menu_textcolor; ?>;
  }
  .main-navigation ul li ul {
    border-color: <?php echo aalto_blogs_rgba( $header_menu_textcolor, 0.4 ); ?>;
  }

  .site-meta {
    border-bottom: 1px solid <?php echo aalto_blogs_rgba( $header_textcolor, 0.4); ?>;
  }
  .site-meta .aalto-menu ul.dropdown-menu {
    background-color: <?php echo $header_background; ?>;
    color: <?php echo $header_menu_textcolor; ?>;
  }
  .site-meta .aalto-menu ul.dropdown-menu li {
    background-color: <?php echo $header_menu_background; ?>; /* Add more opacity by applying the background color both on ul and li */
    border-color: <?php echo aalto_blogs_rgba( $header_menu_textcolor, 0.4 ); ?>;
  }
  .site-meta .aalto-menu ul.dropdown-menu li.aalto-search input[type="search"]::-webkit-input-placeholder {
    color: <?php echo aalto_blogs_rgba( $header_menu_textcolor, 0.7 ); ?>;
    font-style: italic;
  }
  .site-meta .aalto-menu ul.dropdown-menu li.aalto-search input[type="search"]::-moz-placeholder {
    color: <?php echo aalto_blogs_rgba( $header_menu_textcolor, 0.7 ); ?>;
    font-style: italic;
  }
  .site-meta .aalto-menu ul.dropdown-menu li.aalto-search input[type="search"]:-ms-input-placeholder {
    color: <?php echo aalto_blogs_rgba( $header_menu_textcolor, 0.7 ); ?>;
    font-style: italic;
  }
</style>

<?php
}

/**
 * Applies custom post style.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_post_style() {
  global $aalto_colour;
  $background = get_theme_mod( 'post_background_color' ) ?: 'rgba(255,255,255,0.9)';
  $textcolor = get_theme_mod( 'post_textcolor' ) ?: '#333';
  $linkcolor = get_theme_mod( 'link_color' ) ?: $aalto_colour;
  $blockquotecolor = get_theme_mod( 'quote_color' ) ?: 'rgb(140,133,123)';
  $secondarycolor = get_theme_mod( 'secondary_textcolor' ) ?: 'rgb(140,133,123)';

  $css = "
    article.post, article.page, article.attachment,
    article.category-description,
    section.no-results,
    .mu_register,
    .wp-activate-container,
    .comment-respond, .comment-list li,
    .nav-links {
      background: {$background};
      color: {$textcolor};
    }
    .tag-list a,
    .link-excerpt {
      color: {$textcolor};
    }

    article.post p > a,
    article.post p > .span-a-tag,
    article.page p > a,
    article.page p > .span-a-tag,
    article.post ul li > a,
    article.page ul li > a,
    .mu_register a,
    .mu_register input[type='submit'],
    .wp-activate-container a,
    .nav-links > span:not(.dots),
    .page-links > span:not(.page-links-title),
    span.author > a,
    input#submit,
    #cancel-comment-reply-link,
    section.no-results p > a,
    section.no-results input.search-field,
    section.no-results button.search-submit:before {
      color: {$linkcolor};
      border-color: {$linkcolor};
    }

    .mu_register a:hover,
    .mu_register input[type='submit']:hover,
    .wp-activate-container a:hover,
    .nav-links > a:hover,
    .page-links > a:hover {
      color: {$linkcolor};
    }

    article.post blockquote > p,
    article.page blockquote > p {
      color: {$blockquotecolor};
      border-color: {$blockquotecolor};
    }

    .sticky .is-sticky,
    .more-link,
    .comment-count,
    .nav-links > span,
    .nav-links > a,
    .page-links > span,
    .page-links > a,
    .breadcrumbs,
    .mu_register input,
    span.author, .posted-on,
    .logged-in-as,
    .respond-placeholder,
    .comment-reply-link, .comment-reply-login,
    .comment-subscription-form,
    .post-password-form input {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    article table th,
    article table td,
    .table-responsive {
      border-color: {$secondarycolor} !important;
    }
    ::-webkit-input-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    ::-moz-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }
    :-ms-input-placeholder {
      color: {$secondarycolor};
      border-color: {$secondarycolor};
    }

    .comment-list li ol.children {
      border-color: {$secondarycolor};
    }

    .sd-sharing-enabled .sd-content ul li a,
    .sd-sharing-enabled .sd-content ul li a:before {
      color: {$secondarycolor} !important;
      border-color: {$secondarycolor} !important;
    }

    .sd-sharing-enabled .sd-content ul li a:hover,
    .sd-sharing-enabled .sd-content ul li a:hover:before {
      color: {$linkcolor} !important;
      border-color: {$linkcolor} !important;
    }

  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_post_style' );

/**
 * Applies custom body style.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_body_style() {
  $bodytext = get_theme_mod( 'body_textcolor' ) ?: '#333';
  $sidebar_border = aalto_blogs_rgba( $bodytext, 0.4 );
  $css ="
    .comment-section-title,
    .more-posts-section-title,
    .author-section-title,
    hr.section-separator {
      color: {$bodytext};
      border-color: {$bodytext};
    }
    .sidebar * {
      color: {$bodytext};
    }
    .sidebar .widget ul li ul {
      border-color: {$sidebar_border};
    }
  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_body_style' );

/**
 * Applies custom footer style.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_grid_style() {
  global $aalto_colour;
  $background = get_theme_mod( 'grid_background_color' ) ?: 'rgba(255,255,255,0.9)';
  $hovercolor = get_theme_mod( 'grid_hover_color' ) ?: $aalto_colour;
  $textcolor = get_theme_mod( 'grid_textcolor' ) ?: '#FFF';

  $css = "
    .grid-item > article:not(.category-description),
    .grid-item > .pagination > .nav-links {
      background: {$background};
    }

    .grid-item > article > .grid-title-link:hover,
    .grid-item > article.no-thumbnail > .grid-title-link,
    .grid-item > .pagination > .nav-links {
      background: {$hovercolor};
    }

    .grid-item > article > .grid-title-link > .entry-title,
    .grid-item > article.no-thumbnail > .grid-title-link > .entry-title,
    .grid-item > .pagination > .nav-links > span,
    .grid-item > .pagination > .nav-links > a {
      color: {$textcolor};
    }

    .is-mobile .grid-item > article > .grid-title-link {
      background: {$hovercolor};
    }
  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_grid_style' );

/**
 * Applies custom footer style.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_footer_style() {
  global $aalto_colour;
  $textcolor = get_theme_mod( 'footer_textcolor' ) ?: '#FFF';
  $background = get_theme_mod( 'footer_background_color' ) ?: $aalto_colour;

  $css = "
    .site-footer {
      color: {$textcolor};
      background-color: {$background};
    }

    .social-navigation ul li a {
      border: 1px solid {$textcolor};
    }
  ";
  wp_add_inline_style( 'aalto-blogs-style', $css );
}
add_action( 'wp_enqueue_scripts', 'aalto_blogs_footer_style' );

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_customiser_js() {
  if ( SCRIPT_DEBUG ) {
    wp_enqueue_script( 'aalto-blogs-customiser-script', get_template_directory_uri() . '/dev/js/customiser.js', array( 'customize-preview' ), '20160326', true );
  }
  else {
    wp_enqueue_script( 'aalto-blogs-customiser-script', get_template_directory_uri() . '/js/customiser.min.js', array( 'customize-preview' ), '20160326', true );
  }
}
add_action( 'customize_preview_init', 'aalto_blogs_customiser_js' );

/**
 * Initialise Masonry for grid layout.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_masonry_init() {
  if ( wp_script_is( 'aalto-blogs-masonry') ) : ?>
    <script type="text/javascript">
      (function($) {
        var $grid = $( '.masonry-grid' ).masonry( {
          columnWidth: '.grid-width-init',
          itemSelector: '.grid-item',
          percentPosition: true,
        } );

        $grid.imagesLoaded().progress( function() {
          $grid.masonry( 'layout' );
        } );
      })(jQuery);
    </script>
  <?php endif;
}
add_action( 'wp_footer', 'aalto_blogs_masonry_init', 20 );

?>
