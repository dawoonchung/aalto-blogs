/**
 * Colour Preset Control Scripts
 */

( function( api ) {
  var cssTemplate = wp.template( 'aalto-blogs-color-scheme' ),
    colorSchemeKeys = [
      'header_background_color',
      'link_color',
      'footer_background_color'
    ],
    colorSettings = [
      'header_background_color',
      'link_color',
      'footer_background_color'
    ];

  api.controlConstructor.select = api.Control.extend( {
    ready: function() {
      if ( 'department' === this.id ) {
        this.setting.bind( 'change', function( value ) {
          var color = colorScheme[ value ].color;

          api( 'header_background_color' ).set( color );
          api.control( 'header_background_color' ).container.find( '.alpha-color-control' )
            .data( 'data-default-color', color )
            .wpColorPicker( 'defaultColor', color );
          api.control( 'header_background_color' ).container.find( '.wp-color-result' ).css( 'background-color', color );

          api( 'link_color' ).set( color );
          api.control( 'link_color' ).container.find( '.color-picker-hex' )
            .data( 'data-default-color', color )
            .wpColorPicker( 'defaultColor', color );

          api( 'footer_background_color' ).set( color );
          api.control( 'footer_background_color' ).container.find( '.alpha-color-control' )
            .data( 'data-default-color', color )
            .wpColorPicker( 'defaultColor', color );
          api.control( 'footer_background_color' ).container.find( '.wp-color-result' ).css( 'background-color', color );
        } );
      }
    }
  } );

  // Generate the CSS for the current Color Scheme.
  function updateCSS() {
    var scheme = api( 'department' )(),
      css,
      color = _.object( colorSchemeKeys, colorScheme[ scheme ].color );

    // Merge in color scheme overrides.
    _.each( colorSettings, function( setting ) {
      color[ setting ] = api( setting )();
    } );

    css = cssTemplate( color );

    api.previewer.send( 'update-color-scheme-css', css );
  }

  // Update the CSS whenever a color setting is changed.
  _.each( colorSettings, function( setting ) {
    api( setting, function( setting ) {
      setting.bind( updateCSS );
    } );
  } );
  
} )( wp.customize );
