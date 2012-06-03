<?php get_header(); ?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow">
			<header><h2><?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'goodminimal' ), '<span>' . get_the_date() . '</span>' ); ?>
			<?php elseif ( is_month() ) : ?>
				<?php printf( __( 'Monthly Archives: %s', 'goodminimal' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
			<?php elseif ( is_year() ) : ?>
				<?php printf( __( 'Yearly Archives: %s', 'goodminimal' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
			<?php else : ?>
				<?php _e( 'Blog Archives', 'goodminimal' ); //echo ': '.get_category_parents($cat, TRUE, ' ' . $delimiter . ' '); ?>
			<?php endif; ?></h2></header>
								
			
			<?php
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

			<?php endwhile; endif; ?>
			
			<div class="pagination clearfix">
				<?php if(function_exists('wp_pagenavi_archive')) { wp_pagenavi_archive(); } ?>
			</div>
			
		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) : ?>
			<?php endif; ?>
		
		</section>
		
		
    </div>
</section><!-- END: #main-content -->

<?php get_footer(); ?>