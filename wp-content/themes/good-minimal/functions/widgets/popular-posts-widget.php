<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'popular_posts_load_widgets' );

/**
 * Register our widget.
 * 'Last_Comments_Widget' is the widget class used below.
 */
function popular_posts_load_widgets() {
	register_widget( 'popular_Posts_Widget' );
}

/**
 * popular_Posts Widget class.
 */
class popular_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function popular_Posts_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Popular Posts', 'description' => 'The most popular posts' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'popular-posts-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'popular-posts-widget', 'Popular Posts', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$number = $instance['number'];
		$blogbutton = $instance['blogbutton'];
		
		/* Before widget (defined by themes). */			
		echo $before_widget;		
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) echo $before_title . $title . $after_title;
		
		global $wpdb;
		global $shortname;
	
		$temp = $wp_query;
		
		$sql = 'select DISTINCT * from '.$wpdb->posts.' 
			WHERE '.$wpdb->posts.'.post_status="publish" 
			AND '.$wpdb->posts.'.post_type="post" 
			ORDER BY '.$wpdb->posts.'.comment_count DESC
			LIMIT 0,'.$number;
			
		$posts = $wpdb->get_results($sql);
		$output = '
					';
		$output .= '<div class="recent_blog">';

		$post_number = 0;
		foreach ($posts as $post) {
			
			$post_number++;
			//get comments number for each post
			$num_comments = 0;
			$num_comments = get_comments_number($post->ID);
			if ( comments_open() ) {
			if($num_comments == 0) {
			  $comments ="0 ".get_option($shortname."_tr_blog_comments_widget");
				} elseif($num_comments > 1) {
				  $comments = $num_comments." ".get_option($shortname."_tr_blog_comments_widget");
				} else {
				   $comments ="1 ".get_option($shortname."_tr_blog_comment_widget");
				}
				$write_comments = $comments;
			} else { $write_comments = get_option($shortname."_tr_blog_comments_are_off_widget"); }

			
			$post_title = $post->post_title;

			$image_url = get_the_post_thumbnail($post->ID, 'popular_recent_posts', array('title' => the_title_attribute('echo=0')));
			
			if ($post_number == $number) $entry_without_border = ' style="border-bottom:0px;"';
			
			$output .='<div class="recent_entry"'.$entry_without_border.'>
						<div class="tbumbnail"><a href="'.get_permalink($post->ID).'">'.$image_url.'</a></div>
						<h4'.$entry_without_border.'><a href="'.get_permalink($post->ID).'">'.$post_title.'</a></h4>
					</div><!-- END: .popular_entry -->';
		}

		if($blogbutton == 'on') {
			global $wpdb;
			$blog_name_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = 'blog.php'");
			$blog_name_link = get_permalink($blog_name_id);
			
			if ($blog_name_id) {		
				$output .= '<p class="button_wrap"><a href="'.$blog_name_link.'" class="small_button shadow">'.__('Go to Blog', 'goodminimal').'</a></p>';
			}
		}
		
		$output .= '</div>';
		
		echo $output;

		/* After widget (defined by themes). */
		echo $after_widget;
		
		$wp_query = $temp;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['blogbutton'] = strip_tags( $new_instance['blogbutton'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'number' => '3', 'description' => 'The most popular posts.' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php echo 'Count:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number']; ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'blogbutton' ); ?>"><?php echo 'Include button to blog:'; ?></label>
			<input type="checkbox" name="<?php echo $this->get_field_name( 'blogbutton' ); ?>" <?php if($instance['blogbutton']) { echo 'checked="yes"'; } ?> />
			
		</p>
		
	<?php
	}
}

?>