

<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'goodminimal' ); ?></p>

<?php
		return;
	endif;

	if ( have_comments() ) : ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'goodminimal' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'goodminimal' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

		<div id="commentBox" class="roundedBox">
			<div id="comments" class="">
			<h2><?php
			printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'goodminimal' ),
			number_format_i18n( get_comments_number() ));
			?></h2>
			<ol id="commentslist" class="clearfix">
				<?php
					wp_list_comments( array( 'callback' => 'goodminimal_comment' ) );
				?>
			</ol>
			<div class="pagination clearfix"> </div>
			</div>
		<!-- end comments -->			

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'goodminimal' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'goodminimal' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	if ( ! comments_open() ) :
?>
	<!--p class="nocomments"><?php _e( 'Comments are closed.', 'goodminimal' ); ?></p-->
<?php endif; // end ! comments_open() ?>

<?php endif; // end have_comments() ?>

  
    
<?php $comment_args = array( 'fields' => apply_filters( 'comment_form_default_fields', array(
    'author' => '<p><input id="author" name="author" type="text" size="32" tabindex="1" value="' .
                esc_attr( $commenter['comment_author'] ) . '"  />' .
                '<label for="author"> ' . __( 'Your Name' ) . 
                ( $req ? ' *' : '' ) . '</label> <!-- #form-section-author .form-section --></p>',
    'email'  => '<p><input id="email" name="email" type="text" size="32" tabindex="2" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" />' .
		'<label for="email"> ' . __( 'Your Email' ) . ( $req ? ' *' : '' ) .'</label><!-- #form-section-email .form-section --></p>',
    'url'    => '<p><input id="url" name="url" type="text"  size="32" tabindex="3" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" />' .
		'<label for="url"> ' . __( 'Website' ) . '</label><!-- #form-section-url .form-section --></p>' ) ),
    'comment_field' => '<p><textarea name="comment" id="comment" cols="55" rows="12" tabindex="4"></textarea></p><!-- #form-section-comment .form-section -->',
	'id_submit' => 'submit',
	'comment_notes_before' => '',
    'comment_notes_after' => ''
);
echo '<div id="commentForm" class="clear">';
comment_form($comment_args);
echo '</div><!-- end commentform -->';
?>