(function($) {
  /* Position scroll for single posts */
  $(document).ready(function() {
    if($('body').hasClass('single-post')) {
      var headerHeight =$('.site-header').outerHeight();
      $("html,body").scrollTop(headerHeight);
    }
  });


  /* Comment form customisation */
  var hasCommentForm = $('#respond').length;
  if(hasCommentForm) {
    var $mustLogIn = $('.must-log-in');
    if($mustLogIn.length) {
      $('#respond').addClass('force-log-in').click(function() {
        $logInLink = $mustLogIn.attr('data-value');
        window.location = $logInLink;
      });
    }

    $('#respond').not('.force-log-in').click(function(e) {
      if($('#commentform').hasClass('active-form') && $('#comment').val().length) {
        e.stopPropagation();
      }
      else {
        $(this).toggleClass('active-form');
        $('#commentform').toggleClass('active-form').slideToggle(200, function() {
          $('#comment').focus();
        });
      }
      e.stopPropagation();
    });

    $('.comment-reply-link').click(function(e) {
      $('#respond').addClass('active-form');
      $('#commentform').addClass('active-form').slideDown(200, function() {
        $('#comment').focus();
      });
      e.stopPropagation();
    });

    $('#respond textarea, #respond input').click(function(e) {
      e.stopPropagation();
    });

    $(document).click(function() {
      if($('#commentform').hasClass('active-form') && !$('#comment').val().length) {
        $('#respond').removeClass('active-form');
        $('#commentform').removeClass('active-form').slideUp(200);

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

    $('#cancel-comment-reply-link').click(function(e) {
      $('#respond').removeClass('active-form');
      $('#commentform').removeClass('active-form').slideUp(200);
      e.stopPropagation();
    });

    /**
     * Auto resize textarea.
     *
     * Based on: http://stephanwagner.me/auto-resizing-textarea
     */
    $.each($('#respond textarea'), function() {
      var offset = this.offsetHeight - this.clientHeight;
      var resizeTextarea = function(el) {
        $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
      };
      $(this).on('keyup input', function() {
        resizeTextarea(this);
      });
    });
  }
})(jQuery);
