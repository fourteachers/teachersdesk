<?php global $shortname; ?>

<footer id="footer"> 
	<div class="center_wrap">
    	<div class="columns" id="footer_content">
        
            <div class="one_fourth">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 1") ) : ?>
			<?php endif; ?>    				
            </div><!-- END: .recent_blog -->
        
            <div class="one_fourth">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 2") ) : ?>
			<?php endif; ?>    				  
            </div><!-- END: .recent_tweet -->
        
            <div class="one_fourth">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 3") ) : ?>
			<?php endif; ?>
            </div><!-- END: .flickr -->
        
            <div class="one_fourth last">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Column 4") ) : ?>
			<?php endif; ?>    
            </div><!-- END: .about -->        
		
    	</div> <!-- END: #footer_content-->
        <section id="copyright">
		<?php $footer_text = stripslashes(get_option($shortname."_footer_copyright")); ?>
        <span class="float_left"><?php echo $footer_text; ?></span>
        </section>
    </div>
</footer><!-- END: #footer -->

</div><!-- END: #page -->

<?php wp_footer(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery.prettyPhoto.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
	$("a[rel^='prettyPhoto']").prettyPhoto({
		animation_speed: 'fast', /* fast/slow/normal */
		slideshow: 5000, /* false OR interval time in ms */
		autoplay_slideshow: false, /* true/false */
		opacity: 0.70, /* Value between 0 and 1 */
		show_title: true, /* true/false */
		allow_resize: true, /* Resize the photos bigger than viewport. true/false */
		default_width: 800,
		default_height: 544,
		counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
		theme: 'facebook' /* light_rounded / dark_rounded / light_square / dark_square / facebook */
	});
  });
</script>

<?php echo stripslashes(get_option($shortname."_tracking_code"));  ?>

</body>
</html>