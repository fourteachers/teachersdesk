<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'social_links_load_widgets' );

/**
 * Register our widget.
 * 'social_links_Widget' is the widget class used below.
 */
function social_links_load_widgets() {
	register_widget( 'social_links_Widget' );
}

/**
 * social_links Widget class.
 */
class social_links_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function social_links_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'social_links', 'description' => 'List Social Links (with icons).' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'social_links-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'social_links-widget', 'Social Links', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		global $shortname;
		
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		
		/* Before widget (defined by themes). */			
		echo $before_widget;
		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ($title) echo $before_title . $title . $after_title;
		
		//here will be displayed widget content for Footer 1st column 
?>					
<div class="about">
	<ul class="bottom_social_icon">
		<?php 
			if (get_option($shortname.'_social_links_twitter')) { echo '<li class="twitter"><a href="'.get_option($shortname.'_social_links_twitter').'">Twitter</a></li>'; }
			if (get_option($shortname.'_social_links_facebook')) { echo '<li class="facebook"><a href="'.get_option($shortname.'_social_links_facebook').'">Facebook</a></li>'; }
			if (get_option($shortname.'_social_links_dribbble')) { echo '<li class="dribbble"><a href="'.get_option($shortname.'_social_links_dribbble').'">Dribbble</a></li>'; }
			if (get_option($shortname.'_social_links_delicious')) { echo '<li class="delicious"><a href="'.get_option($shortname.'_social_links_delicious').'">Delicious</a></li>'; }
			if (get_option($shortname.'_social_links_skype')) { echo '<li class="skype"><a href="'.get_option($shortname.'_social_links_skype').'">Skype</a></li>'; }
			if (get_option($shortname.'_social_links_google')) { echo '<li class="googleplus"><a href="'.get_option($shortname.'_social_links_google').'">Google+</a></li>'; }
		?>
	</ul>
</div>
		
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

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => 'Social Links' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Title:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
?>