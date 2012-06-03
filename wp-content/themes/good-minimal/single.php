<?php get_header(); ?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow center_wrap blogText">
			<header><h2><?php
				global $wpdb;
				$blog_name_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = 'blog.php'");
				echo get_post_meta($blog_name_id, $shortname.'_title_bar',true);
			?></h2></header>					
			
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="post clearfix no_bottom_border">
					<h2 class="blog_title"><?php the_title();?></h2>
	
				<div class="meta clearfix"> <?php _e('Posted by', 'goodminimal'); ?> <a href="#"><?php the_author_posts_link(); ?> <?php _e('on', 'goodminimal'); ?> <a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'),get_the_time('d')); ?>"><?php echo get_the_time('F d, Y'); ?></a> <?php _e('in', 'goodminimal'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments', 'goodminimal'),__('1 Comment', 'goodminimal'), __('% Comments', 'goodminimal')); ?> <br /> <?php echo the_tags('Tags: ', ', ', ''); ?> </div>
					
					<?php
						$portfolio_image_original = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', false );
						$get_custom_image_url = $portfolio_image_original[0];
						$image_url = get_the_post_thumbnail($post->ID, 'post_single_page', array('title' => the_title_attribute('echo=0')));
						if ($get_custom_image_url) echo '<p>'.$image_url.'</p>';
						
						
						
$Meta=array();

$grade=get_post_meta($post->ID, 'wpcf-grade');
$subject = get_post_meta($post->ID, 'wpcf-subject');
$class = get_post_meta($post->ID, 'wpcf-classes');
$teks = get_post_meta($post->ID, 'wpcf-teks');
$Meta['Grade']=$grade[0];
$Meta['Subject']=$subject[0];
$Meta['Class']=$class[0];
$Meta['TEKS']=$teks[0];

echo '<ul class="meta_list">';
foreach($Meta as $label=>$metatag)
{
echo '<li>'.$label.' : '.$metatag.'</li>';
}
echo '</ul>';

the_content();
//echo print_r($key_1_values ,true);		
						comments_template( '', true );
					?>
					
				</div><!-- END: .post-->

			<?php endwhile; ?>

		</section>

		<section id="sidebar">
		
			
		
			<?php			
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