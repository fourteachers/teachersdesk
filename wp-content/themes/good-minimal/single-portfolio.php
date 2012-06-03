<?php get_header(); ?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow">
			<header><h2><?php
				global $wpdb;
				$portfolio_name_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value like 'portfolio-%'");
				echo get_the_title($portfolio_name_id);
			?></h2></header>					
			
			<?php 
				$temp = $wp_query;
				while ( have_posts() ) : the_post(); 
			?>
				<div class="post clearfix no_bottom_border">
					<h2 class="blog_title"><?php the_title();?></h2>
					
					<?php
						$item_categories = get_the_terms( $id, 'portfolio_entries' );
						if(is_object($item_categories) || is_array($item_categories)) {
							$cat_slug = '';
							foreach ($item_categories as $cat) {
								if ($cat_slug) $cat_slug .= ', '.$cat->name;
								if (!$cat_slug) $cat_slug .= $cat->name;
							}
						}				
					?>	
					
					<div class="meta clearfix"> <?php _e('Posted on', 'goodminimal'); ?> <?php echo get_the_time('F dS, Y'); ?> <?php _e('in', 'goodminimal'); ?> <?php echo $cat_slug; ?></div>
					
					<?php
						$portfolio_image_original = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
						$get_custom_image_url = $portfolio_image_original[0];		
						$image_url = get_the_post_thumbnail($post->ID, 'post_single_page', array('title' => the_title_attribute('echo=0')));
						if ($get_custom_image_url) {
							echo '<p id="image-grid"><a href="'.$get_custom_image_url.'" rel="prettyPhoto[mixed]" class="thumb">'.$image_url.'</a></p>';
						}
					?>
						
					<?php the_content(); ?>
					
					<!--/div></li></ul></div-->
					<?php //comments_template( '', true ); ?>
					
				</div><!-- END: .post-->

			<?php endwhile; ?>

		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Portfolio Sidebar") ) : ?>
			<?php endif; ?>
		
			<?php 
				//$wp_query = null; $wp_query = $temp;
				wp_reset_query();
				$custom = get_post_custom($post->ID);
				$current_sidebar = $custom["current_sidebar"][0];	
				
				if ($current_sidebar) {
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($current_sidebar) ) :
					endif;
				}
			?>
		
		</section>
		
    </div>
</section><!-- END: #main-content -->

<?php get_footer(); ?>