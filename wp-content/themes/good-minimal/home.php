
<?php get_header(); 
/*
Template Name: Home
*/
?>

<style>
#content{
border:0;
background:none;
padding:0 4% 0 4%;
line-height:1.2em;

font-size:1.2em;
}
</style>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow center_wrap homePage">
			
			
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
