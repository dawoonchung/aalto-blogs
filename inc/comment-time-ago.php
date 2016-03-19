<?php
/**
 * Custom walker class extension to display comment timestamp in 'time ago' format.
 *
 * @package WordPress
 * @subpackage Aalto_Blogs
 * @since Official Aalto Blogs Theme 1.0
 */
class Walker_Comment_Time_Ago extends Walker_Comment {
	protected function html5_comment( $comment, $depth, $args ) {
		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <aside class="comment-metadata">
          <figure class="author-avatar">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
          </figure><!-- .author-avatar -->
          <?php
            $edit_comment_link = get_edit_comment_link() ? '<span class="edit-link"> · <a class="post-edit-link" href="' . get_edit_comment_link() . '">Edit</a></span>' : '';
            printf( '<span class="author">%1$s %2$s</span>', get_comment_author_link( $comment ), $edit_comment_link );
           ?>
          <span class="posted-on">
            <time datetime="<?php comment_time( 'c' ); ?>">
              <?php echo get_aalto_blogs_time_ago( get_comment_time( 'U' ) ); ?>
            </time>
          </span>
        </aside><!-- .comment-metadata -->

        <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
        <?php endif; ?>

        <?php comment_text(); ?>

				<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="reply">',
					'after'     => '</div>'
				) ) );
				?>
			</article><!-- .comment-body -->
<?php
	}
}
?>
