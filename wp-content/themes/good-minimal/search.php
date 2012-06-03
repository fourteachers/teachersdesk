<?php get_header(); ?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow">
			<header><h2 class="page_title"><?php printf( __( 'Search Results for: %s', 'goodminimal' ), '<span>' . get_search_query() . '</span>' ); ?></h2></header>

			<?php
				$s = $_GET['s'];
				
				$args=array(
					'post_type' => 'post',
					's' => $s,
					'post_status' => 'publish',
					'paged' => $paged
				);
				
				$wp_query = new WP_Query($args);
				
				if (have_posts()) : while (have_posts()) : the_post();
				
				$image_url = get_the_post_thumbnail($post->ID, 'blog_listing', array('class' => 'postThumb', 'title' => the_title_attribute('echo=0')));
			?>
				<div class="post clearfix">
					<a href="<?php the_permalink(); ?>" class="post_thumb"><?php echo $image_url; ?></a>
					<div class="inside">
						<h2 class="blog_title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
						<div class="meta clearfix"> <?php _e('Posted by', 'goodminimal'); ?> <a href="#"><?php the_author_posts_link(); ?> <?php _e('on', 'goodminimal'); ?> <a href="<?php echo get_day_link(get_the_time('Y'), get_the_time('m'),get_the_time('d')); ?>"><?php echo get_the_time('F d, Y'); ?></a> <?php _e('in', 'goodminimal'); ?> <?php the_category(', ') ?> | <?php comments_popup_link(__('0 Comments', 'goodminimal'),__('1 Comment', 'goodminimal'), __('% Comments', 'goodminimal')); ?> </div>
						
						<?php the_excerpt(); ?>
						
						<p class="moreLink"><a href="<?php the_permalink(); ?>" class="small_button"><?php _e('Continue Reading...', 'goodminimal'); ?></a></p>
					</div>
				</div><!-- END: .post-->

			<?php endwhile; ?>
				<?php else : ?>
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'goodminimal' ); ?></h2>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'goodminimal' ); ?></p>
					<form action="#" method="get" class="search">
						<p><input type="text" name="s" id="s" class="shadow_inset" value="<?php _e('Search...', 'goodminimal'); ?>" onblur="if (this.value == ''){this.value = '<?php _e('Search...', 'goodminimal'); ?>'; }" onfocus="if (this.value == '<?php _e('Search...', 'goodminimal'); ?>') {this.value = '';}" /></p>
					</form>
					<div style="height:100%">&nbsp;</div>
			<?php endif; ?>

			<div class="pagination clearfix">
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } $wp_query = null; $wp_query = $temp; ?>
			</div>
		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) : ?>
			<?php endif; ?>

			<?php 
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