<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'flickr_load_widgets' );

/**
 * Register our widget.
 * 'flickr_Widget' is the widget class used below.
 */
function flickr_load_widgets() {
	register_widget( 'flickr_Widget' );
}

/**
 * flickr Widget class.
 */
class flickr_Widget extends WP_Widget {


	/**
	 * Widget setup.
	 */
	function flickr_Widget() {


		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flickr', 'description' => 'Last flickr photos.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'flickr-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'flickr-widget', 'Flickr', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$flickr_username = $instance['flickr_username'];
		$flickr_count = $instance['flickr_count'];
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		//here will be displayed widget content for Footer 1st column 
?>					

<div id="flickr_badge_wrapper">
<script flickr_type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $flickr_count; ?>&amp;flickr_display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $flickr_username; ?>"></script>
</div>
<p class="button_wrap"><a href="http://www.flickr.com/photos/<?php echo $flickr_username; ?>" class="small_button shadow"><?php _e('See More Photos', 'goodminimal'); ?></a></p> 
		
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
		$instance['flickr_username'] = strip_tags( $new_instance['flickr_username'] );
		$instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'flickr_count' => '6', 'description' => 'Last flickr photos' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 

	$url_get_flickr_id = 'http://www.idgettr.com';
		
?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_username' ); ?>"><?php echo 'Flickr ID (<a href="'.$url_get_flickr_id.'" target="_blank">idGettr</a>):'; ?></label>
			<input id="<?php echo $this->get_field_id( 'flickr_username' ); ?>" name="<?php echo $this->get_field_name( 'flickr_username' ); ?>" value="<?php echo $instance['flickr_username']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_count' ); ?>"><?php echo 'Number of photos:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'flickr_count' ); ?>" name="<?php echo $this->get_field_name( 'flickr_count' ); ?>" value="<?php echo $instance['flickr_count']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>