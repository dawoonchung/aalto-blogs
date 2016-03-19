<?php
/**
 * Custom editor features
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Customise TinyMCE Editor.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function custom_tiny_mce_options( $in ) {
  $style_formats = array(
    array(
      'title' => 'Paragraph',
      'block' => 'p'
    ),
    array(
      'title' => 'Heading 1',
      'block' => 'h3'
    ),
    array(
      'title' => 'Heading 2',
      'block' => 'h4'
    ),
    array(
      'title' => 'Heading 3',
      'block' => 'h5'
    )
  );

  $paste_preprocess = 'function(plugin, args) {' .
                        'var filtered = args.content.replace(/<h3/g, "<h5");' .
                        'filtered = filtered.replace(/<\/h3>/g, "</h5>");' .
                        'filtered = filtered.replace(/<h2/g, "<h4");' .
                        'filtered = filtered.replace(/<\/h2>/g, "</h4>");' .
                        'filtered = args.content.replace(/<h1/g, "<h3");' .
                        'filtered = filtered.replace(/<\/h1>/g, "</h3>");' .
                      '}';

  $in[ 'style_formats' ]                 = json_encode( $style_formats );
  $in[ 'paste_remove_styles' ]           = true;
  $in[ 'paste_remove_spans']             = true;
  $in[ 'invalid_styles' ]                = 'font-weight font-size font-style font-family';
  $in[ 'invalid_elements' ]              = 'h1, h2';
  $in[ 'paste_strip_class_attributes' ]  = 'all';
  $in[ 'paste_retain_style_properties' ] = 'none';
  $in[ 'menubar' ]                       = true;
  $in[ 'plugins' ]                       = 'charmap, colorpicker, compat3x, directionality, fullscreen, hr, image, lists, media, paste, tabfocus, textcolor, wordpress, wpautoresize, wpdialogs, wpeditimage, wpembed, wpemoji, wpgallery, wplink, wptextpattern, wpview';
  $in[ 'toolbar1' ]                      = 'undo, redo, |, styleselect, bold, italic, underline, forecolor, removeformat, |, alignleft, aligncenter, alignright, alignjustify, |, link, blockquote, table, |, bullist, numlist, outdent, indent, |, wp_help, dfw';
  $in[ 'toolbar2' ]                      = '';
  $in[ 'paste_preprocess' ]              = $paste_preprocess;
  return $in;
}
add_filter( 'tiny_mce_before_init', 'custom_tiny_mce_options' );

/**
 * Load TinyMCE plugins.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function custom_tiny_mce_plugins() {
  $plugins_array[ 'table' ] = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.2.8/plugins/table/plugin.min.js';
  return $plugins_array;
}
add_filter( 'mce_external_plugins', 'custom_tiny_mce_plugins' );

/**
 * Force match background color for tinyMCE menubar through CSS.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function custom_admin_style() {
  wp_enqueue_style( 'custom-admin-style', get_template_directory_uri() . '/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'custom_admin_style' );

?>
