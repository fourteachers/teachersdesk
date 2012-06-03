<?php
get_header();
?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow">
			<header><h2><?php _e( 'Not Found', 'goodminimal' ); ?></h2></header>

			<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'goodminimal' ); ?></p>			
						
		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) : ?>
			<?php endif; ?>
		
		</section>		
		
    </div>
</section><!-- END: #main-content -->

<?php get_footer(); ?>