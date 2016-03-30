(function($) {

/**
 * Check if main navigation has nested menu, and if it is adds class to reduce the height
 */
function detectNestedMenu() {
  if ( $( '.primary-menu' ).find( '.menu-item-has-children' ).length ) {
    $( '.primary-menu' ).addClass( 'has-nested-menu' );
  }
}

/**
 * Detect menu with less than 5 items
 */
function hasSingleLine() {
  $navbar = $( '.main-navigation' );
  if ( $navbar.find( '.primary-menu' ).find( 'li' ).length < 5 ) {
    $navbar.addClass( 'single-row' );
    $( '.navbar-header' ).addClass( 'single-row' );
  }
}

/**
 * Adjust header image placeholder's height
 */
var headerHeightSet = false;
function setHeaderHeight() {
  if ( headerHeightSet ) {
    return false;
  }

  if ( ! $( '.site-header-menu' ).length ) {
    $( 'head' ).append( '<style type="text/css" id="aalto-blogs-header-min-height">@media (min-width: 992px) { .site-header { min-height: 190px; }' + ' }</style>' );
    headerHeightSet = true;
    return false;
  }

  var textAreaHeight = $( '.header-text-area' ).outerHeight();
  var brandHeight = $( '.header-text-area > .container' ).outerHeight();
  var navHeight = $( '.site-header-menu' ).outerHeight();
  var targetHeight = (16/9) * navHeight;
  var extraHeight = targetHeight - brandHeight;

  if ( extraHeight < 40 ) {
    extraHeight = 40;
  }

  var finalHeight = textAreaHeight + extraHeight;

  $( 'head' ).append( '<style type="text/css" id="aalto-blogs-header-min-height">@media (min-width: 992px) { .site-header { min-height: ' + finalHeight + 'px; }' + ' }</style>' );
  headerHeightSet = true;
}

/**
 * Initialise gallery slide
 */
function Slider( selector ) {
  $this = $( selector );
  this.id = $this.attr( 'id' );
  this.slides = $this.children( 'figure' );
  this.width = $this.outerWidth();

  this.Init = function() {
    var slideId = this.id;
    var shiftWidth = this.width;
    var i = 0;

    this.slides.each( function() {
      var slideImg = $( this ).find( 'img' ).attr( 'src' );
      $( this ).css( 'background-image', 'url(' + slideImg + ')' ).css( 'left', i * shiftWidth ).attr( 'slide-count', i++).attr( 'slide-id', slideId );
    } ) ;

    if( !$this.find( 'nav' ).length ) {
      $this.append( '<nav class="gallery-navigation" slide-id="' + this.id + '"><span class="gallery-prev" slide-data="prev"></span><span class="gallery-next" slide-data="next"></span></nav>' );
      $this.addClass( 'slider-initialised' ).attr( 'current-slide', 0 ).attr( 'total-slides', i-1 );
    }
    else {
      goToSlide( slideId, $this.attr( 'current-slide' ) );
    }

  };
}

/**
 * Initialise gallery navigation
 */
function galleryNavInit() {
  $( '.gallery-navigation span' ).click( function() {
    var direction = $( this ).attr( 'slide-data' );
    var slideId = $( this ).parent().attr( 'slide-id' );
    var currentSlide = $( '#' + slideId ).attr( 'current-slide' );
    var totalSlides = $( '#' + slideId ).attr( 'total-slides' );
    var slideIndex;

    if ( direction == 'prev' ) {
      slideIndex = currentSlide == '0' ? totalSlides : --currentSlide;
    }
    if ( direction == 'next' ) {
      slideIndex = currentSlide == totalSlides ? 0 : ++currentSlide;
    }

    goToSlide( slideId, slideIndex );
  } ) ;
}

/**
 * Set slide position
 */
function goToSlide( slideId, slideIndex ) {
  $slide = $( '#' + slideId);
  shiftWidth = $slide.outerWidth() * slideIndex * -1;
  $slide.attr( 'current-slide', slideIndex );
  $slide.children( 'figure' ).css("transform","translateX(" + shiftWidth + "px)");
}

/**
 * Initialise image classes
 */
function initImageClass() {
  $( 'article.post p, article.page p, figure.wp-caption' ).has( 'img:not(.wp-smiley)' ).each( function() {
    $( this ).not( 'figure.wp-caption' ).addClass( 'has-image' );

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
      }
      else {
        $( this ).addClass( 'small-width' );
      }
      $( this ).find( '.wp-caption-text' ).css( 'maxWidth', sizeCheck + 'px' );
    }
  } ) ;

  $( 'article.post p, article.page p' ).has( '.alignleft' ).each( function() {
    $( this ).addClass( 'alignleft' );
  } ) ;
  $( 'article.post p, article.page p' ).has( '.alignright' ).each( function() {
    $( this ).addClass( 'alignright' );
  } ) ;
  $( 'article.post p, article.page p' ).has( 'iframe' ).each( function() {
    $( this ).addClass( 'has-embed' );
  } ) ;
}

/**
 * Check image position in relation with sidebar.
 * Executed after elements are fully loaded to deal better with images (especially for Safari).
 */
function initImagePosition() {
  if ( $( 'body' ).hasClass( 'active-sidebar' ) && ( $( 'body' ).hasClass( 'single-post' ) || $( 'body' ).hasClass( 'page' ) ) && ! $( '.content-area' ).hasClass( 'reading-mode' ) ) {
    var $sidebar = $( '.sidebar' );
    var sidebarPos = $sidebar.offset();
    var sidebarPosBottom = sidebarPos.top + $sidebar.height();

    $( 'article.post p, article.page p, figure.wp-caption' ).has( 'img:not(.wp-smiley)' ).each( function() {
      var imgPos = $( this ).offset();
      var imgPosTop = imgPos.top;

      if ( imgPosTop > sidebarPosBottom ) {
        $( this ).addClass( 'below-sidebar' );
      }
    } );

    $( '.gallery' ).not( '.gallery-size-thumbnail' ).each( function() {
      var imgPos = $( this ).offset();
      var imgPosTop = imgPos.top;

      if ( imgPosTop > sidebarPosBottom ) {
        $( this ).addClass( 'below-sidebar' );
        var slider = new Slider( this );
        slider.Init();
      }
    } );
  }
}

/* Comment form customisation */
function initCommentForm() {
  var hasCommentForm = $( '#respond' ).length;
  if ( hasCommentForm ) {
    var $mustLogIn = $( '.must-log-in' );
    if ( $mustLogIn.length ) {
      $( '#respond' ).addClass( 'force-log-in' ).click( function() {
        $logInLink = $mustLogIn.attr( 'data-value' );
        window.location = $logInLink;
      } ) ;
    }

    $( '#respond' ).not( '.force-log-in' ).click( function( e ) {
      if ( $( '#commentform' ).hasClass( 'active-form' ) && $( '#comment' ).val().length ) {
        e.stopPropagation();
      }
      else {
        $( this ).toggleClass( 'active-form' );
        $( '#commentform' ).toggleClass( 'active-form' ).slideToggle( 200, function() {
          $( '#comment' ).focus();
        } ) ;
      }
      e.stopPropagation();
    } ) ;

    $( '.comment-reply-link' ).click( function( e ) {
      $( '#respond' ).addClass( 'active-form' );
      $( '#commentform' ).addClass( 'active-form' ).slideDown( 200, function() {
        $( '#comment' ).focus();
      } ) ;
      e.stopPropagation();
    } ) ;

    $( '#respond textarea, #respond input, #respond label').click( function( e ) {
      e.stopPropagation();
    } ) ;

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
    } ) ;

    $( '#cancel-comment-reply-link' ).click( function( e ) {
      $( '#respond' ).removeClass( 'active-form' );
      $( '#commentform' ).removeClass( 'active-form' ).slideUp( 200 );
      e.stopPropagation();
    } ) ;

    /**
     * Auto resize textarea.
     *
     * @url http://stephanwagner.me/auto-resizing-textarea
     */
    $.each( $( '#respond textarea' ), function() {
      var offset = this.offsetHeight - this.clientHeight;
      var resizeTextarea = function( el ) {
        $( el ).css( 'height', 'auto' ).css( 'height', el.scrollHeight + offset );
      };
      $( this ).on( 'keyup input', function() {
        resizeTextarea( this );
      } ) ;
    } ) ;
  }
}

$( document ).ready(function() {
  detectNestedMenu();
  hasSingleLine();

  if ( $( window ).width() > 991 ) {
    setHeaderHeight();
  }
  /**
   * Make tables responsive
   */
  $( 'article' ).find( 'table' ).wrap( '<div class="table-responsive"></div>' );

  /**
   * Position scroll for single posts
   */
  if ( $( 'body' ).hasClass( 'single-post' ) ) {
    var headerHeight = $( '.site-header' ).outerHeight();
    var screenWidth = $( window ).width();

    if ( screenWidth < 601 && $( 'body' ).hasClass( 'admin-bar' ) ) {
      headerHeight += 46;
      console.log( headerHeight );
    }

    $( "html, body" ).scrollTop( headerHeight );
  }

  if ( $( 'body' ).hasClass( 'single-post' ) || $( 'body' ).hasClass( 'page' ) ) {
    initImageClass();

    $( '.gallery' ).not( '.gallery-size-thumbnail' ).each( function() {
      var slider = new Slider( this );
      slider.Init();
    } ) ;

    galleryNavInit();

    $( '.gallery-caption' ).wrapInner( '<span></span>' ).siblings( '.gallery-icon' ).append( '<div class="overlay"></div>' );

    /* Experimental feature */
    // var $firstImg = $( '.entry-title + p, .entry-title + figure.wp-caption' ).has( 'img' );
    // var imgSrc = $firstImg.children( 'img' ).attr( 'src' );
    // $firstImg.css( 'background-image', 'url(' + imgSrc + ')' ).css( 'background-size', 'cover' ).css( 'background-attachment', 'fixed' );
  }

  initCommentForm();

  /**
   * Prevent empty search.
   */
  $( '.search-submit' ).click( function(e) {
    var $searchForm = $( this ).siblings( 'label' ).children( '.search-field' );
    if ( ! $searchForm.val().length ) {
      e.preventDefault();
      $searchForm.focus();
    }
  } );
} ) ;

$( window ).load( function() {
  initImagePosition();
} );

var TO = false;
var smMax = 991;
$( window ).resize( function() {
  if ( $( window ).width() > smMax && ! headerHeightSet ) {
    setHeaderHeight();
  }

  if( TO !== false ) {
    clearTimeout( TO );
    $( '.gallery > figure' ).fadeOut(100).css( 'transition', 'none' );
  }
  TO = setTimeout( function() {
    $( '.gallery' ).not( '.gallery-size-thumbnail' ).each( function() {
      var slider = new Slider( this );
      slider.Init();
    } ) ;
    $( '.gallery > figure' ).css( 'transition', 'transform 0.5s ease-in-out' ).fadeIn(300);
  }, 300 );
} );

})(jQuery);
