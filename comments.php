<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<hr class="section-separator col-xs-2 col-xs-offset-5" />
<div id="comments" class="comments-area col-xs-12">
  <div class="row">
    <h6 class="comment-section-title">Responses</h6>
    <?php
      $user = wp_get_current_user();
      $user_email = $user->exists() ? $user->user_email : '';
      $user_identity = $user->exists() ? $user->display_name : 'Your email will not be published';
      $user_avatar = get_avatar( $user_email, 40 );
      $post_id = get_the_ID();
      $comment_args = array(
        'comment_field'         => '<p class="comment-form-comment"><span class="screen-reader-text">Comment </span><textarea id="comment" name="comment" rows="3" aria-required="true"></textarea></p>',
        'label_submit'          => 'Publish',
        'title_reply'           => '<figure class="author-avatar">' . $user_avatar . '</figure><span class="respond-placeholder">Write your thoughts...</span><span class="logged-in-as">' . $user_identity . '</span></a>',
        'must_log_in'          => '<span class="must-log-in" data-value="' . wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) . '">You must be logged in to post a comment.</span>',
        'title_reply_before'    => '',
        'title_replly_after'    => '',
        'logged_in_as'          => '',
        'comment_notes_before'  => '',
        'cancel_reply_link'     => ' · Cancel reply'
      );
      comment_form( $comment_args );
    ?>
    <?php if ( have_comments() ) : ?>
      <ol class="comment-list">
        <?php
          wp_list_comments( array(
            'walker'      => new Walker_Comment_Time_Ago(),
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 40,
          ) );
        ?>
      </ol><!-- .comment-list -->

      <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav class="navigation pagination comments-navigation comments-pagination" role="navigation">
          <h2 class="screen-reader-text">Comments navigation</h2>
          <div class="nav-links">
            <?php paginate_comments_links( array(
              'prev_text'          => '&lt;',
              'next_text'          => '&gt;',
              'before_page_number' => '<span class="meta-nav screen-reader-text">Page</span>'
            ) ); ?>
            </div>
        </nav>
      <?php endif; // Check for comments pagination. ?>

    <?php endif; // Check for have_comments(). ?>
  </div>
</div><!-- .comments-area -->
