tinymce.PluginManager.add( 'quote', function( editor ) {
  editor.on( 'init', function() {
    editor.formatter.register( 'quote', { inline : 'q', classes : 'quote' } );
  });

  editor.addButton( 'quote', {
    icon: 'blockquote',
    type: 'splitbutton',
    tooltip: 'Blockquote',
    onclick: function() {
      if( editor.formatter.match( 'quote' ) || editor.formatter.matchNode( 'quote' ) )
        editor.formatter.remove( 'quote' );
      editor.formatter.toggle( 'blockquote' );
    },

    menu: [{
      text: 'Inline Quote',
      onclick: function() {
        if( editor.formatter.match( 'blockquote' ) )
          editor.formatter.remove( 'blockquote' );
        editor.formatter.toggle( 'quote' );
      }
    }]
  });
});
