<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'twitter_load_widgets' );

/**
 * Register our widget.
 * 'Twitter_Widget' is the widget class used below.
 */
function twitter_load_widgets() {
	register_widget( 'Twitter_Widget' );
}

/**
 * Twitter Widget class.
 */
class Twitter_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Twitter_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'twitter', 'description' => 'Last Twitter Updates.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'twitter-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'twitter-widget', 'Twitter', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$twitter_username = $instance['twitter_username'];
		$twitter_count = $instance['twitter_count'];
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		//here will be displayed widget content for Footer 1st column 
?>					
		<!--span id="twitter_update_list_<?php echo $twitter_username; ?>"></span-->
		<div class="recent_tweet">
			<ul id="twitter_update_list_<?php echo $twitter_username; ?>" class="tweet_list"><li>&nbsp;</li></ul>
			<p class="button_wrap"><a href="http://www.twitter.com/<?php echo $twitter_username; ?>" class="small_button shadow" target="_blank"><?php _e('Follow Us', 'goodminimal'); ?></a></p> 
		</div>		
		<!-- twitter start script -->
		
		<script type="text/javascript">	
			function twitterCallback_<?php echo $twitter_username; ?>(twitters) {
			  var statusHTML = [];
			  for (var i=0; i<twitters.length; i++){
				var username = twitters[i].user.screen_name;
				var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
				  return '<a href="'+url+'">'+url+'</a>';
				}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
				  return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
				});
				statusHTML.push('<li><span>'+status+'</span> <p style="clear:both; font-size: 85%;">'+relative_time(twitters[i].created_at)+'</p></li>');
				

			  }
			  document.getElementById('twitter_update_list_<?php echo $twitter_username; ?>').innerHTML = statusHTML.join('');
			}
		</script>
		
		<!--script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/twitter.js"></script-->
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $twitter_username; ?>.json?callback=twitterCallback_<?php echo $twitter_username; ?>&amp;count=<?php echo $twitter_count; ?>"></script>
		<!-- twitter end script -->	
		
<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['twitter_username'] = strip_tags( $new_instance['twitter_username'] );
		$instance['twitter_count'] = strip_tags( $new_instance['twitter_count'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Last Twitter Updates' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_username' ); ?>"><?php echo 'Twitter Username:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'twitter_username' ); ?>" value="<?php echo $instance['twitter_username']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_count' ); ?>"><?php echo 'Count:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'twitter_count' ); ?>" name="<?php echo $this->get_field_name( 'twitter_count' ); ?>" value="<?php echo $instance['twitter_count']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>