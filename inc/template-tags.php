<?php
/**
 * Custom Official Aalto Blogs Theme template tags
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_entry_meta() {
  $author_avatar_size = apply_filters( 'aalto_blogs_author_avatar_size', 40 );
  $edit_post_link = get_edit_post_link() ? '<span class="edit-link"> &middot; <a class="post-edit-link" href="' . get_edit_post_link() . '">Edit</a><span class="screen-reader-text"> ' . get_the_title() . '</span></span>' : '';

  if ( 'post' === get_post_type() ) {
    $post_categories = ' in ' . get_the_category_list( ', ' );
    printf( '<figure class="author-avatar">%1$s</figure><span class="author"><span class="screen-reader-text">Author </span> <a class="url fn n" href="%2$s">%3$s</a>%4$s %5$s</span>%6$s',
      get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      get_the_author(),
      $post_categories,
      $edit_post_link,
      get_aalto_blogs_entry_date()
    );
  }

  if ( 'page' === get_post_type() ) {
    printf( '<figure class="author-avatar">%1$s</figure><span class="author"><span class="screen-reader-text">Author </span> <a class="url fn n" href="%2$s">%3$s</a>%4$s</span>%5$s',
      get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      get_the_author(),
      $edit_post_link,
      get_aalto_blogs_entry_date()
    );
  }
}

/**
 * Return adjacent posts links.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_retrieve_posts( $posts_list ) {
  $has_post = false;
  foreach ( $posts_list as $single_post ) {
    if ( !empty( $single_post ) ) {
      $has_post = true;
      break;
    }
  }
              
  if ( $has_post ) :
    ?>
		<hr class="section-separator col-xs-2 col-xs-offset-5" />
    <div class="col-xs-12 more-posts">
      <h6 class="more-posts-section-title">More posts from this category</h6>
      <div class="row more-posts-list">
        <?php foreach ( $posts_list as $single_post ) :
          if ( !empty( $single_post ) ) :
            global $post;
            $post = $single_post;
						setup_postdata( $post );
						get_template_part( 'template-parts/content', get_post_format() );
						wp_reset_postdata( $post );
          endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif;
}

if ( ! function_exists( 'aalto_blogs_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail, or the first image of a post if thumbnail is not set.
 *
 * @since Official Aalto Blogs Theme 1.0
 */ 
function aalto_blogs_post_thumbnail( $size = 'post-thumbnail' ) {
  if ( post_password_required() || is_attachment() || ( ! has_post_thumbnail() && ! get_the_first_attachment_for_post() ) ) {
    return;
  }
	?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
    <?php if ( has_post_thumbnail() ) {
      the_post_thumbnail( $size, array(
        'alt' => the_title_attribute( 'echo=0' ),
        'class' => 'img-responsive'
      ) );
    }
    else {
      echo get_the_first_attachment_for_post( '', $size, array(
        'alt' => the_title_attribute( 'echo=0' ),
        'class' => 'img-responsive wp-post-image'
      ) );
    }
    ?>
	</a>
<?php } 
endif;

/**
 * Get the first attachment for a post
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function get_the_first_attachment_for_post( $post = null, $size = null, $data = null ) {
  if ( ! $post ) global $post;
  $args = array(
    'numberposts' => '1',
    'post_type'   => 'attachment',
    'post_status' => null,
    'post_parent' => $post->ID,
    'orderby'     => 'date',
    'exclude'     => get_post_thumbnail_id($post->ID)
  );
  $attachments = get_posts($args);

  if ( ! empty( $attachments ) ) {
    return wp_get_attachment_image( $attachments[0]->ID, $size, false, $data );
  }

  return null;
}

if ( ! function_exists( 'aalto_blogs_excerpt_html' ) ) :
/**
 * Allow some HTML elements in post excerpts.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_excerpt_html( $text = '' ) {
  $allowed_tags = '<em>,<strong>,<span>,<p>,<h3>,<h4>,<h5>,<blockquote>,<ul>,<ol>,<li>,<dl>,<dt>,<dd>,<table>,<thead>,<tbody>,<tfoot>,<tgroup>,<th>,<tr>,<td>';
  $raw_excerpt = $text;
  if ( '' == $text ) {
    $text = get_the_content('');
    $text = strip_shortcodes( $text );
    $text = apply_filters( 'the_content', $text );
    $text = str_replace( ']]>', ']]&gt;', $text );
    $text = str_replace( '<a', '<span class="span-a-tag"', $text );
    $text = str_replace( '</a>', '</span>', $text );
		$text = strip_tags($text, $allowed_tags);
    $excerpt_length = apply_filters( 'excerpt_length', 30 );

		$tokens = array();
		$excerptOutput = '';
		$count = 0;

		// Divide the string into tokens; HTML tags, or words, followed by any whitespace
		preg_match_all( '/(<[^>]+>|[^<>\s]+)\s*/u', $text, $tokens );

		foreach ( $tokens[0] as $token ) { 
			if ( $count-1 >= $excerpt_length ) { 
        $excerptOutput .= str_replace( array( ' ', '.', ',' ), '', $token );
				break;
			}

			// Add words to complete sentence
			$count++;

			// Append what's left of the token
			$excerptOutput .= $token;
		}

		$text = trim( force_balance_tags( $excerptOutput ) );

    return $text;
  }

  /**
   * Filter the trimmed excerpt string.
   *
   * @since 2.8.0
   *
   * @param string $text        The trimmed text.
   * @param string $raw_excerpt The text prior to trimming.
   */
  return apply_filters( 'aalto_blogs_excerpt_html', $text, $raw_excerpt );
}
endif;

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'aalto_blogs_excerpt_html' ); 

function aalto_blogs_excerpt() {
	if ( has_excerpt() ) :
    the_excerpt();
  else :
    echo get_the_excerpt();
  endif;
}

if ( ! function_exists( 'get_aalto_blogs_entry_date' ) ) :
/**
 * Customise timestamp format for posts.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function get_aalto_blogs_entry_date() {
  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

  $from = get_the_time( 'U' );
  $time_display = get_aalto_blogs_time_ago( $from );

  if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
  }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    $time_display,
    esc_attr( get_the_modified_date( 'c' ) ),
    get_the_modified_date()
  );

  $output = '<span class="posted-on"><span class="screen-reader-text">Posted on </span>' . $time_string . '</span>';
  return $output;
}
endif;

/**
 * Calculate and return time ago format.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function get_aalto_blogs_time_ago( $from ) {
  $to = current_time( 'timestamp' );
  $diff = (int) abs( $to - $from );

  if ( $diff < WEEK_IN_SECONDS ) {
    $timeago = human_time_diff( $from, $to );
    $time_output = ( $timeago == '2 days' ) ? 'Yesterday' : $timeago . ' ago';
  } else {
    $time_output = get_the_date();
  }

  return $time_output;
}

if ( ! function_exists( 'aalto_blogs_comment_default_fields' ) ) :
/**
 * Customise comment default fields.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_comment_default_fields( $args = array() ) {
  $commenter = wp_get_current_commenter();

  $args = wp_parse_args( $args );
  if ( ! isset( $args['format'] ) )
    $args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
 
  $req      = get_option( 'require_name_email' );
  $aria_req = ( $req ? " aria-required='true'" : '' );
  $html_req = ( $req ? " required='required'" : '' );
  $html5    = 'html5' === $args['format'];

  $fields   =  array(
    'author' => '<p class="comment-form-author"><span class="screen-reader-text">Name </span>' .
                '<input id="author" name="author" type="text" placeholder="Name' . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>',
    'email'  => '<p class="comment-form-email"><span class="screen-reader-text">Email </span>' .
                '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="Email' . ( $req ? '*' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p>',
    'url'    => '<p class="comment-form-url"><span class="screen-reader-text">Website </span>' .
                '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="Website" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
  );

  return $fields;
}
endif;
add_filter( 'comment_form_default_fields', 'aalto_blogs_comment_default_fields' );

?>
