<?php
/*
Template Name: Page Full Width
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
				} 
			?></h2></header>

			<?php			
				$image_url = get_the_post_thumbnail($post->ID, 'page_fullwidth_header', array('title' => the_title_attribute('echo=0')));
				
				if ( has_post_thumbnail()) {
					echo '<p>'.$image_url.'</p>';
				}
				
				while ( have_posts() ) : the_post();
					the_content();
				endwhile; 
			?>
			
		</section>
		
    </div>
</section><!-- END: #main-content -->

<?php get_footer(); ?>