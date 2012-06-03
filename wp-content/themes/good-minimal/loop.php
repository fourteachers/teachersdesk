<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if ( $wp_query->max_num_pages > 1 ) : ?>
	<div id="nav-above" class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'infinity' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'infinity' ) ); ?></div>
	</div><!-- #nav-above -->
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'infinity' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'infinity' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif;

	while ( have_posts() ) : the_post();

	if ( in_category( _x('gallery', 'gallery category slug', 'infinity') ) ) :
?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'infinity' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php infinity_posted_on(); ?>

	<?php elseif ( in_category( _x('asides', 'asides category slug', 'infinity') ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if ( is_archive() || is_search() ) : // Display excerpts for archives and search. ?>
			
				<?php the_excerpt(); ?>
			
		<?php else : ?>
			
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinity' ) ); ?>
			
		<?php endif; ?>

			
		<?php infinity_posted_on(); ?>
			

	<?php else : ?>
		<div class="post">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'infinity' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<?php infinity_posted_on(); ?>
			<?php
				$get_custom_options =  wp_get_attachment_image_src(get_post_meta($post->ID, '_thumbnail_id', true), '_wp_attachment_metadata', true);
				$image_url = $get_custom_options[0];
			?>
			<a href="<?php echo $image_url; ?>" class="thumb" rel="portfolio"><?php the_post_thumbnail('blog_post_image'); ?></a>
			

	<?php if ( is_archive() || is_search() ) : // Only display excerpts for archives and search. ?>
			
				<?php the_excerpt(); ?>
			
	<?php else : ?>
			
			
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'infinity' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'infinity' ), 'after' => '</div>' ) ); ?>
			
	<?php endif; ?>

				<p class="text-button"><a href="<?php the_permalink(); ?>" class="ie6fix">Continue Reading</a></p>
			</div><!-- #post-## --> 
		<?php comments_template( '', true ); ?>

	<?php endif; // This was the if statement that broke the loop into three parts based on categories. ?>

<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'infinity' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'infinity' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>
