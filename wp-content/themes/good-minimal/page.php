<?php get_header(); ?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow center_wrap">
			<header><h2><?php //get page section title
				if (get_post_meta($post->ID, $shortname.'_title_bar',true)) {
						echo get_post_meta($post->ID, $shortname.'_title_bar',true);
				} else { 
					echo $post->post_title; 
				} 
			?></h2></header>
			
			<?php			
				$image_url = get_the_post_thumbnail($post->ID, 'page_sidebar_header', array('title' => the_title_attribute('echo=0')));
				
				if ( has_post_thumbnail()) {
					echo '<p>'.$image_url.'</p>';
				}
				
				while ( have_posts() ) : the_post();
					the_content();
				endwhile; 
			?>
			
		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Page Sidebar") ) : ?>
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