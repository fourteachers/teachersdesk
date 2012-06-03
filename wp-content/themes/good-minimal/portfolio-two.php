<?php
/*
Template Name: Portfolio Two Columns
*/
get_header();
?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="full_width container_shadow">
			<header><h2><?php //get page section title
							if (get_post_meta($post->ID, $shortname.'_title_bar',true)) {
									echo get_post_meta($post->ID, $shortname.'_title_bar',true);
							} else { 
								echo $post->post_title; 
							} ?></h2></header>
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
			
			<div id="portfolio">
				<ul class="display_thumbnail two_col" id="image-grid">
				<?php
					$thePostID = $post->ID;
					$get_custom_options = get_option($shortname.'_portfolio_page_id'); 
					$cat_inclusion = trim($get_custom_options['portfolio_to_cat_'.$thePostID]);
					
					if ($cat_inclusion) {
						$type = 'portfolio';
						$args=array(
						'post_type' => $type,
						'tax_query' => array(
										array(
											'taxonomy' => 'portfolio_entries',
											'field' => 'id',
											'terms' => $cat_inclusion
										 )
										),
						'post_status' => 'publish',
						'posts_per_page' => get_option($shortname.'_portfolio_items_count'),
						'sort_column' => 'menu_order',
						'order' => 'desc',
						'paged' => $paged
						);
					} else {
						$type = 'portfolio';
						$args=array(
						'post_type' => $type,
						'post_status' => 'publish',
						'posts_per_page' => get_option($shortname.'_portfolio_items_count'),
						'sort_column' => 'menu_order',
						'order' => 'desc',
						'paged' => $paged
						);					
					}
					
					$temp = $wp_query;  // assign original query to temp variable for later use   
					$wp_query = null;
					$wp_query = new WP_Query($args); 

					$i = 0;
					if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();

						{
							
							$i++; 
							
							// get full image from featured image if was not see full image url in Portfolio
							$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
							$get_custom_image_url = $get_custom_options[0];
							$portfolio_image = get_the_post_thumbnail($post->ID, 'portfolio_two', array('title' => the_title_attribute('echo=0')));							

							$custom = get_post_custom($post->ID);
							$portfolio_video_url = $custom["portfolio_video_url"][0];						
							if ($portfolio_video_url) $get_custom_image_url = $portfolio_video_url;

							if ($i == 3) {
								$i = 1;
								echo '<li class="thumb" style="clear:left;">';
							} else echo '<li class="thumb">';
														
							echo '
									<a href="'.$get_custom_image_url.'" rel="prettyPhoto[gallery_'.$post->ID.']" class="thumb">'.$portfolio_image.'</a>
									<h4>'.get_the_title().'</h4>';
							
										
								$attachment_args = array(
									'post_type' => 'attachment',
									'numberposts' => -1,       
									'post_status' => null,
									'post_parent' => $post->ID,
									'orderby' => 'menu_order ID'
								);

								$output_pagination = '';
								$site_url_images = get_site_url();
								$attachments = get_posts($attachment_args);
								$hidden_image_number = 0;
								if ($attachments) {
									foreach($attachments as $gallery ) {
										$hidden_image_number++;
										//if ($hidden_image_number != count($attachments)) {
										if ($hidden_image_number > 0) {
											$current_attachment_url =  wp_get_attachment_url($gallery->ID);
											$imgage_attachment_url =  str_replace($site_url_images,'',$current_attachment_url);
											if ($get_custom_image_url != $current_attachment_url) {
											
												echo '<a style="visibility:hidden; height:0px; width:0px;" href="'.$imgage_attachment_url.'" rel="prettyPhoto[gallery_'.$post->ID.']" class="thumb" title="&nbsp;&nbsp;&nbsp;'.$gallery->post_title.'"></a>';
											
											}
										} //end to check if $hidden_image_number != 'last image number'
									}
								}	
								
							the_excerpt();
							
							$custom = get_post_custom($post->ID);
							$portfolio_website_url = $custom["portfolio_website_url"][0];
							
							if ($portfolio_website_url) $portfolio_website_url = '<a class="small_button shadow" href="'.$portfolio_website_url.'">'.__('Visit Website', 'goodminimal').'</a>';
			
							echo '
									<div><a class="small_button shadow" href="'.get_permalink().'">'.__('View Details', 'goodminimal').'</a>'.$portfolio_website_url.'</div>
								</li>						
							';						
						}


					endwhile;
					endif;
				?>
				</ul>
			</div>
			
			<div class="pagination clearfix" style="clear:left;">
				<?php 
					if(function_exists('wp_pagenavi_archive')) { wp_pagenavi_archive();
						wp_reset_postdata(); 
					}
					
					$wp_query = null;
					$wp_query = $temp;
				?>
			</div>
			
		</section>	
		
    </div>
</section><!-- END: #main-content -->

<?php get_footer(); ?>