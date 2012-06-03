<?php get_header(); ?>

<aside id="slider_wrap">
<!--div id="slider">


</div--><!-- END: #slider -->
	<div id="slider_home">
	<div class="flexslider">
		<ul class="slides">
			<?php 
				$type = 'slider';
				$args=array(
					'post_type' => $type,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'asc'
				);
				$temp = $wp_query;  // assign original query to temp variable for later use   
				$wp_query = null;
				$wp_query = new WP_Query($args);

				if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
					$custom = get_post_custom($post->ID);

					$slider_image = get_the_post_thumbnail($post->ID, 'homepageslider', array('title' => the_title_attribute('echo=0')));
					
					$slider_website_url = '';
					$slider_description = '';
					$custom = get_post_custom($post->ID);
					$slider_website_url = $custom["slider_website_url"][0];
					$slider_description = $custom["slider_description"][0];
					
					$slider_description_output = '';
					if ($slider_description) {
						$slider_description_output = '<p class="flex-caption">'.$slider_description.'</p>';
					}
					
					$slider_video_url = trim($custom["slider_video_url"][0]);
					
					if ($slider_video_url == '') {
			?>
			<li>
				<a href="<?php echo $slider_website_url; ?>"><?php echo $slider_image; ?></a>
				<?php echo $slider_description_output; ?>
			</li> 
			<?php			
					} else {
			?>
			<li>
				<div class="video-container"><iframe id="player" src="<?php echo $slider_video_url; ?>" frameborder="0"></iframe>
				<?php //echo $slider_description_output; ?></div>
			</li> 
			<?php
					}
					
				endwhile;
				endif; 
			?>
		</ul>
	</div>
	</div>
	<!-- /End Full Width Slider-->
		
</aside><!-- END: #slider_wrap -->

<section id="main-content">
	<div class="center_wrap">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Homepage Widgets Area") ) : ?>
		<?php endif; ?>

		<?php if (!get_option($shortname.'_hide_portfolio_homepage')) { ?>
		<div class="columns" id="latest_work">
			<header><h3><?php _e('Latest Work', 'goodminimal'); ?></h3></header>
			<?php			
				global $wpdb;
				$portfolio_name_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value like 'portfolio%'");
				$portfolio_name_link = get_permalink($portfolio_name_id);
				
				if ($portfolio_name_id) {
			?>
			<div><a href="<?php echo $portfolio_name_link; ?>" class="small_button shadow"><?php _e('View Portfolio', 'goodminimal'); ?></a></div>
				<?php } //end to get portfolio url?>
				
			<ul class="thumb_list" id="image-grid">
			
				<?php 
					$type = 'portfolio';
					$args=array(
					'post_type' => $type,
					'post_status' => 'publish',
					'posts_per_page' => '4',
					'sort_column' => 'menu_order',
					'order' => 'desc'
					);
					$temp = $wp_query;  // assign original query to temp variable for later use   
					$wp_query = null;
					$wp_query = new WP_Query($args); 

					$i = 0;
					if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
						
						$i++; 
						
						// get full image from featured image if was not see full image url in Portfolio
						$get_custom_options = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
						$get_custom_image_url = $get_custom_options[0];
						
						$portfolio_image = get_the_post_thumbnail($post->ID, 'homepageportfolio', array('title' => the_title_attribute('echo=0')));
						
						$custom = get_post_custom($post->ID);
						$portfolio_video_url = $custom["portfolio_video_url"][0];						
						if ($portfolio_video_url) $get_custom_image_url = $portfolio_video_url;
						
						if ($i == 1) $li_class = 'first';
						if ($i == 2) $li_class = 'second';
						if ($i == 3) $li_class = 'third';
						if ($i == 4) $li_class= 'fourth last';
						if ($i == 5) $li_class = 'first';
						if ($i == 6) $li_class = 'second';
						if ($i == 7) $li_class = 'third';
						if ($i == 8) $li_class= 'fourth last';
						
						echo '<li class="'.$li_class.' thumb"><a href="'.$get_custom_image_url.'"  rel="prettyPhoto[mixed]" class="thumb">'.$portfolio_image.'</a></li>';

					endwhile;
					endif;
				?>

			</ul>
		</div>
		<?php } ?>
		
    </div>
</section><!-- END: #main-content -->
 
<?php get_footer(); ?>