var $ = jQuery;

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
    });

    if( !$this.find( 'nav' ).length ) {
      $this.append( '<nav class="gallery-navigation" slide-id="' + this.id + '"><span class="gallery-prev" slide-data="prev"></span><span class="gallery-next" slide-data="next"></span></nav>' );
      $this.addClass( 'slider-initialised' ).attr( 'current-slide', 0 ).attr( 'total-slides', i-1 );
    }
    else {
      goToSlide( slideId, $this.attr( 'current-slide' ) );
    }

  };
}

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
  });
}

function goToSlide( slideId, slideIndex ) {
  $slide = $( '#' + slideId);
  shiftWidth = $slide.outerWidth() * slideIndex * -1;
  $slide.attr( 'current-slide', slideIndex );
  $slide.children( 'figure' ).css("transform","translateX(" + shiftWidth + "px)");
}
