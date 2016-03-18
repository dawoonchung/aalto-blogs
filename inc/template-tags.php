<?php
/**
 * Custom Official Aalto Blogs Theme template tags
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

if ( ! function_exists( 'aalto_blogs_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_entry_meta() {
  if ( 'post' === get_post_type() ) {
    $author_avatar_size = apply_filters( 'aalto_blogs_author_avatar_size', 40 );
    $post_categories = ' in ' . get_the_category_list( ', ' );
    $edit_post_link = get_edit_post_link() ? '<span class="edit-link"> · <a class="post-edit-link" href="' . get_edit_post_link() . '">Edit</a><span class="screen-reader-text"> ' . get_the_title() . '</span></span>' : '';
    printf( '<figure class="author-avatar">%1$s</figure><span class="author"><span class="screen-reader-text">Author </span> <a class="url fn n" href="%2$s">%3$s</a>%4$s %5$s</span>%6$s',
      get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
      esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
      get_the_author(),
      $post_categories,
      $edit_post_link,
      get_aalto_blogs_entry_date()
    );
  }

/*
  $format = get_post_format();
  if ( current_theme_supports( 'post-formats', $format ) ) {
    printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
      sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'twentysixteen' ) ),
      esc_url( get_post_format_link( $format ) ),
      get_post_format_string( $format )
    );
  }

  if ( 'post' === get_post_type() ) {
    twentysixteen_entry_taxonomies();
  }

  if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
    comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'twentysixteen' ), get_the_title() ) );
    echo '</span>';
  }
}
*/
}
endif;

if ( ! function_exists( 'aalto_blogs_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail, or the first image of a post if thumbnail is not set.
 *
 * @since Official Aalto Blogs Theme 1.0
 */ 
function aalto_blogs_post_thumbnail() {
  if ( post_password_required() || is_attachment() || ( ! has_post_thumbnail() && ! get_the_first_attachment_for_post() ) ) {
    return;
  }
	?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">

	<?php if ( has_post_thumbnail() ) {
    the_post_thumbnail( 'post-thumbnail', array(
      'alt' => the_title_attribute( 'echo=0' ),
      'class' => 'img-responsive'
    ) );
  }
  else {
    echo get_the_first_attachment_for_post( '', 'post-thumbnail', array(
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
function get_the_first_attachment_for_post($post = null, $size = null, $data = null) {
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

  if (!empty($attachments)) {
    return wp_get_attachment_image($attachments[0]->ID, $size, false, $data);
  }

  return null;
}

if ( ! function_exists( 'aalto_blogs_excerpt_html' ) ) :
/**
 * Allow some HTML elements in post excerpts.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function aalto_blogs_custom_excerpt( $text = '' ) {
  $allowed_tags = '<em>,<strong>,<span>,<p>,<h3>,<h4>,<h5>';
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
  return apply_filters( 'aalto_blogs_custom_excerpt', $text, $raw_excerpt );
}
endif;

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'aalto_blogs_custom_excerpt'); 

if ( ! function_exists( 'get_aalto_blogs_entry_date' ) ) :
/**
 * Customise timestamp format.
 *
 * @since Official Aalto Blogs Theme 1.0
 */
function get_aalto_blogs_entry_date() {
  $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

  $from = get_the_time( 'U' );
  $to = current_time( 'timestamp' );
  $diff = (int) abs( $to - $from );

  if ( $diff < WEEK_IN_SECONDS ) {
    $timeago = human_time_diff( $from, $to );
    $time_display = ( $timeago == '2 days' ) ? 'Yesterday' : $timeago . ' ago';
  } else {
    $time_display = get_the_date();
  }

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


?>
