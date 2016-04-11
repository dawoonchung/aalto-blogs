/**
 * Live-update changed settings in real time in the Customizer preview.
 */

(function($) {
  var style = $( '#aalto-blogs-color-scheme-css' ),
      api = wp.customize;

  if ( ! style.length ) {
    style = $( 'head' ).append( '<style type="text/css" id="aalto-blogs-color-scheme-css" />' )
                       .find( '#aalto-blogs-color-scheme-css' );
  }
  
  // Site title.
  api( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '.site-title a' ).text( to );
    } );
  } );

  // Site tagline.
  api( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '.site-description' ).text( to );
    } );
  } );

  // Add custom-background-image body class when background image is added.
  api( 'background_image', function( value ) {
    value.bind( function( to ) {
      $( 'body' ).toggleClass( 'custom-background-image', '' !== to );
    } );
  } );

  // Header background.
  api( 'header_background_color', function( value ) {
    value.bind( function( to ) {
      $( '.site-header' ).css( 'background-color', to );
    } );
  } );

  // Header menu background.
  api( 'header_menu_color', function( value ) {
    value.bind( function( to ) {
      $( '.site-header-menu' ).css( 'background-color', to );
    } );
  } );

  // Post background.
  api( 'post_background_color', function( value ) {
    value.bind( function( to ) {
      var selector = 'article.post, article.page, article.attachment, section.no-results, .comment-respond, .comment-list li, .nav-links';
      $( selector ).css( 'background-color', to );
    } );
  } );

  // Grid background.
  api( 'grid_background_color', function( value ) {
    value.bind( function( to ) {
      var selector = '.grid-item > article, .grid-item > .pagination > .nav-links';
      $( selector ).css( 'background-color', to );
    } );
  } );

  // Footer background.
  api( 'footer_background_color', function( value ) {
    value.bind( function( to ) {
      $( '.site-footer' ).css( 'background-color', to );
    } );
  } );

  // Color Scheme CSS
  api.bind( 'preview-ready', function() {
    api.preview.bind( 'update-color-scheme-css', function( css ) {
      style.html( css );
    } );
  } );

})(jQuery);
