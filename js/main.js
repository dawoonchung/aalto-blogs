(function($) {

$( document ).ready(function() {
  /**
   * Make tables responsive
   */
  $( 'article' ).find( 'table' ).wrap( '<div class="table-responsive"></div>' );

  /**
   * Scripts for single post.
   */
  if ( $( 'body' ).hasClass( 'single-post' ) ) {
    /* Position scroll for single posts */
    var headerHeight = $( '.site-header' ).outerHeight();
    $( "html, body" ).scrollTop( headerHeight );
  }

  if ( $( 'body' ).hasClass( 'single-post' ) || $( 'body' ).hasClass( 'page' ) ) {
    $( 'article.post p, article.page p, figure.wp-caption' ).has( 'img:not(.wp-smiley)' ).each( function() {
      var sizeCheck = $( this ).find( 'img' ).attr( 'width' );
      if ( sizeCheck > 1140 ) {
        $( this ).addClass( 'full-width' );
      }
      else if ( sizeCheck > 788 ) {
        $( this ).addClass( 'large-width' );
      }
      else if ( !$( this ).find( 'img' ).hasClass( 'size-thumbnail' ) ) {
        $( this ).addClass( 'default-width' );
      }
      else {
        if ( $( '.reading-mode' ).length ) {
          $( this ).addClass( 'small-width' ).wrap( '<div class="container"></div>' );
          $( this ).find( '.wp-caption-text' ).css( 'maxWidth', sizeCheck + 'px' );
        }
      }
    });

    $( 'article.post p, article.page p' ).has( '.alignleft' ).each( function() {
      $( this ).addClass( 'alignleft' );
    });
    $( 'article.post p, article.page p' ).has( '.alignright' ).each( function() {
      $( this ).addClass( 'alignright' );
    });
    $( 'article.post p, article.page p' ).has( 'iframe' ).each( function() {
      $( this ).addClass( 'has-embed' );
    });

    $( '.gallery' ).not( '.gallery-size-thumbnail' ).each( function() {
      var slider = new Slider( this );
      slider.Init();
    });

    galleryNavInit();

    var TO = false;
    $( window ).resize( function() { // Adjust gallery slide positions on AFTER resize
      if( TO !== false ) {
        clearTimeout( TO );
        $( '.gallery > figure' ).fadeOut(100).css( 'transition', 'none' );
      }
      TO = setTimeout( function() {
        $( '.gallery' ).not( '.gallery-size-thumbnail' ).each( function() {
          var slider = new Slider( this );
          slider.Init();
        });
        $( '.gallery > figure' ).css( 'transition', 'transform 0.5s ease-in-out' ).fadeIn(300);
      }, 300 );
    });

    /* Experimental feature */
    // var $firstImg = $( '.entry-title + p, .entry-title + figure.wp-caption' ).has( 'img' );
    // var imgSrc = $firstImg.children( 'img' ).attr( 'src' );
    // $firstImg.css( 'background-image', 'url(' + imgSrc + ')' ).css( 'background-size', 'cover' ).css( 'background-attachment', 'fixed' );
  }

  /* Comment form customisation */
  var hasCommentForm = $( '#respond' ).length;
  if ( hasCommentForm ) {
    var $mustLogIn = $( '.must-log-in' );
    if ( $mustLogIn.length ) {
      $( '#respond' ).addClass( 'force-log-in' ).click( function() {
        $logInLink = $mustLogIn.attr( 'data-value' );
        window.location = $logInLink;
      });
    }

    $( '#respond' ).not( '.force-log-in' ).click( function( e ) {
      if ( $( '#commentform' ).hasClass( 'active-form' ) && $( '#comment' ).val().length ) {
        e.stopPropagation();
      }
      else {
        $( this ).toggleClass( 'active-form' );
        $( '#commentform' ).toggleClass( 'active-form' ).slideToggle( 200, function() {
          $( '#comment' ).focus();
        });
      }
      e.stopPropagation();
    });

    $( '.comment-reply-link' ).click( function( e ) {
      $( '#respond' ).addClass( 'active-form' );
      $( '#commentform' ).addClass( 'active-form' ).slideDown( 200, function() {
        $( '#comment' ).focus();
      });
      e.stopPropagation();
    });

    $( '#respond textarea, #respond input ').click( function( e ) {
      e.stopPropagation();
    });

    $( document ).click( function() {
      if ( $( '#commentform' ).hasClass( 'active-form' ) && !$( '#comment' ).val().length ) {
        $( '#respond' ).removeClass( 'active-form' );
        $( '#commentform' ).removeClass( 'active-form' ).slideUp( 200 );

        // Cancel reply when clicked outside of div,
        // so that users won't struggle to find reply form.
        var t       = addComment,
          temp      = t.I( 'wp-temp-form-div' ),
          respond   = t.I( t.respondId ),
          cancle    = t.I( 'cancel-comment-reply-link' );

        if ( ! temp || ! respond ) {
          return;
        }

        t.I( 'comment_parent' ).value = '0';
        temp.parentNode.insertBefore( respond, temp );
        temp.parentNode.removeChild( temp );
        cancle.style.display = 'none';
        cancle.onclick = null;
        return false;
      }
    });

    $( '#cancel-comment-reply-link' ).click( function( e ) {
      $( '#respond' ).removeClass( 'active-form' );
      $( '#commentform' ).removeClass( 'active-form' ).slideUp( 200 );
      e.stopPropagation();
    });

    /**
     * Auto resize textarea.
     *
     * Based on: http://stephanwagner.me/auto-resizing-textarea
     */
    $.each( $( '#respond textarea' ), function() {
      var offset = this.offsetHeight - this.clientHeight;
      var resizeTextarea = function( el ) {
        $( el ).css( 'height', 'auto' ).css( 'height', el.scrollHeight + offset );
      };
      $( this ).on( 'keyup input', function() {
        resizeTextarea( this );
      });
    });
  }
});

})(jQuery);