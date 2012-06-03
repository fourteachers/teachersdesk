<?php
	/* Create Sliders Items */
	function create_slider() {
    	$slider_args = array(
        	'label' => __('Slider','goodminimal'),
        	'singular_label' => __('Slider','goodminimal'),
        	'public' => true,
        	'show_ui' => true,
        	'capability_type' => 'post',
        	'hierarchical' => true,
        	'rewrite' => true,
			'menu_position' => 5,
        	'supports' => array('title','thumbnail', 'page-attributes')
        );
    	register_post_type('slider',$slider_args);
	}
	
	add_action('init', 'create_slider');
	
	add_action('admin_init', 'add_slider');
	add_action('save_post', 'update_slider_website_url');
	
	function add_slider(){
		add_meta_box("slider_details", "Slider Options", "slider_options", "slider", "normal", "low");
	}
	
	function slider_options(){
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;		
		$custom = get_post_custom($post->ID);
		$slider_website_url = $custom["slider_website_url"][0];
		$slider_description = $custom["slider_description"][0];
		$slider_video_url = $custom["slider_video_url"][0];
		
?>
	<div id="slider-options">
		<table>
			<tr>
				<td>
					<small><strong>Video slide URL</strong></small><br />
					<small>Enter YouTube or Vimeo url to show in the slider instead the image</small><br /><br />
					Examples: 
						<br />Vimeo video - http://player.vimeo.com/video/6284199?title=0&byline=0&portrait=0
						<br />YouTube video - http://www.youtube.com/embed/NmRTreaCJXs<br /><br />
					<input style="width: 600px" name="slider_video_url" value="<?php echo $slider_video_url; ?>" /><br /><br />
				</td>
			</tr>		
			<tr>
				<td>
					<small><strong>Slide link URL</strong></small><br />
					<small>URL the Slide gets linked to</small><br /><br />
					<input style="width: 600px" name="slider_website_url" value="<?php echo $slider_website_url; ?>" /><br /><br />
				</td>
			</tr>
			<tr>
				<td>
					<small><strong>Slide Description</strong></small><br />
					<small>Enter slide description</small><br /><br />
					<textarea name="slider_description" id="slider_description" cols="117" rows="5"><?php echo $slider_description; ?></textarea><br /><br />
				</td>
			</tr>
		</table>
	</div><!--end slider-options-->   
<?php
	}
	
	function update_slider_website_url(){
		global $post;
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		} else {				
			update_post_meta($post->ID, "slider_website_url", $_POST["slider_website_url"]);
			update_post_meta($post->ID, "slider_description", $_POST["slider_description"]);
			update_post_meta($post->ID, "slider_video_url", $_POST["slider_video_url"]);
		}
	}

add_filter("manage_edit-slider_columns", "slider_edit_columns");
add_action("manage_posts_custom_column",  "slider_custom_columns");

function slider_edit_columns($columns){

		$newcolumns = array(
			"title" => "Title"
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function slider_custom_columns($column){
		global $post;
		switch ($column)
		{
			case "slider_image":
				$image_id = get_post_thumbnail_id($post->ID);
				$image_url = wp_get_attachment_image_src($image_id,'marketplace', true);
				$get_custom_image_url = $image_url[0];
				echo '<img src="'.$get_custom_image_url.'" height="67px" style="padding: 5px 10px 20px 5px; "/>';
				break;
		}
}
?>