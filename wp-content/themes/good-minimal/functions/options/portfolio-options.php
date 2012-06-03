<?php
	add_action('init', 'portfolio_register');

	function portfolio_register() {
		  $labels = array(
		    'name' => _x('Portfolio', 'post type general name'),
		    'singular_name' => _x('Portfolio Entry', 'post type singular name'),
		    'add_new' => _x('Add New', 'portfolio'),
		    'add_new_item' => __('Add New Portfolio Entry'),
		    'edit_item' => __('Edit Portfolio Entry'),
		    'new_item' => __('New Portfolio Entry'),
		    'view_item' => __('View Portfolio Entry'),
		    'search_items' => __('Search Portfolio Entries'),
		    'not_found' =>  __('No Portfolio Entries found'),
		    'not_found_in_trash' => __('No Portfolio Entries found in Trash'), 
		    'parent_item_colon' => ''
		  );

		global $paged;
	
    	$args = array(
        	'labels' => $labels,
        	'public' => true,
        	'show_ui' => true,
			'_builtin' => false,
        	'rewrite' => array('slug'=>'portfolio-item','with_front'=>false),
			'capability_type' => 'post',
			'hierarchical' => false,
        	'show_in_nav_menus'=> false,
			'query_var' => true,
			'paged' => $paged,			
        	'menu_position' => 5,
        	'supports' => array('title','thumbnail','excerpt','editor','comments','page-attributes')
        );

    	register_post_type( 'portfolio' , $args );
    	
    	
    	register_taxonomy("portfolio_entries", 
					    	array("portfolio"), 
					    	array(	"hierarchical" => true, 
					    			"label" => "Portfolio Categories", 
					    			"singular_label" => "Portfolio Categories", 
					    			'rewrite' => array('slug' => 'portfolio-category'),
					    			"query_var" => true,
									'paged' => $paged
					    		));  
		flush_rewrite_rules( false );	
	}

	add_action('admin_init', 'add_portfolio');
	flush_rewrite_rules(false);
	
	add_action('save_post', 'update_portfolio');
	function add_portfolio(){
		add_meta_box("portfolio_details", "Portfolio Options", "portfolio_options", "portfolio", "normal", "low");
	}
	function portfolio_options(){
		global $meta_box, $post, $shortname;
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
		
		$custom = get_post_custom($post->ID);
		$portfolio_video_url = $custom["portfolio_video_url"][0];
		$portfolio_website_url = $custom["portfolio_website_url"][0];
		$current_sidebar = $custom["current_sidebar"][0];
?>
	<div id="portfolio-options">
	
		<table>

		
			<tr>
				<td>
					<label>Video URL (instead of image on popup): </label>
				</td>
				<td>
					<label>&nbsp;&nbsp;&nbsp;</label>
				</td>
				<td>
					<input style="width:500px" name="portfolio_video_url" value="<?php echo $portfolio_video_url; ?>" /><br><br>
				</td>
			</tr>

			
		
			<tr>
				<td>
					<label>Website URL: </label>
				</td>
				<td>
					<label>&nbsp;&nbsp;&nbsp;</label>
				</td>
				<td>
					<input style="width:500px" name="portfolio_website_url" value="<?php echo $portfolio_website_url; ?>" /><br><br>
				</td>
			</tr>
			
			<tr>
				<td>
					<label>Select Sidebar: </label>
				</td>
				<td>
					<label>&nbsp;&nbsp;&nbsp;</label>
				</td>
				<td>
					<?php

						echo '<select name="current_sidebar">';	
						echo '<option value=""></option>';		
						
						
						$get_custom_options = get_option($shortname.'_sidebar_list');
						$m = 0;
						for($i = 1; $i <= 200; $i++) 
						{
							if ($get_custom_options[$shortname.'_sidebar_list_url_'.$i])
							{	
								if ( $current_sidebar == $get_custom_options[$shortname.'_sidebar_list_url_'.$i] ) { 
									?>
										<option selected value='<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?></option>";
									<?php	
								} else {
									?>
										<option value='<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?></option>";
									<?php 
								}
							}
						}
						echo '</select>';
						echo '<br/><span>Select sidebar and info in Widgets.</span>';					
					?>
				</td>
			</tr>			

		</table>
	</div><!--end portfolio-options-->   
<?php
	}
	function update_portfolio(){
		global $post;
		
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
			return $post_id;
		} else {
			update_post_meta($post->ID, "portfolio_video_url", $_POST["portfolio_video_url"]);
			update_post_meta($post->ID, "portfolio_website_url", $_POST["portfolio_website_url"]);
			update_post_meta($post->ID, "current_sidebar", $_POST["current_sidebar"]);
		}
	}
	
#portfolio_columns, <-  register_post_type then append _columns
add_filter("manage_edit-portfolio_columns", "prod_edit_columns");
add_action("manage_posts_custom_column",  "prod_custom_columns");

function prod_edit_columns($columns){

		$newcolumns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Title",
			"portfolio_entries" => "Categories"
		);
		
		$columns= array_merge($newcolumns, $columns);

		return $columns;
}

function prod_custom_columns($column){
		global $post;
		switch ($column)
		{
			case "portfolio_entries":
				echo get_the_term_list($post->ID, 'portfolio_entries', '', ', ','');
				break;
		}
}
?>