<?php
/*
Template Name: Contact Template
*/
global $shortname;
if ( get_option($shortname.'_recaptcha_enabled') ) {

    if ( !function_exists('_recaptcha_qsencode') ) {
		require_once('functions/recaptchalib.php');
    }

    $publickey = get_option($shortname.'_recaptcha_publickey');
    $privatekey = get_option($shortname.'_recaptcha_privatekey');
	
    /*
	$resp = null;
    $error = null;
	
    if( isset($_POST['submit']) ) {
		$resp = recaptcha_check_answer ($privatekey,
		    $_SERVER["REMOTE_ADDR"],
		    $_POST["recaptcha_challenge_field"],
		    $_POST["recaptcha_response_field"]
		);
		
		if ( !$resp->is_valid ) {
			$reCaptcha_error = $resp->error;
		}
		
    }
	*/
	
}

get_header();
?>

<section id="main-content">
	<div class="center_wrap">
	
		<section id="content" class="container_shadow">
			<header><h2><?php //get page section title
							if (get_post_meta($post->ID, $shortname.'_title_bar',true)) {
									echo get_post_meta($post->ID, $shortname.'_title_bar',true);
							} else { 
								echo $post->post_title; 
							} ?></h2></header>
							
			<?php			
				$image_url = get_the_post_thumbnail($post->ID, 'page_sidebar_header', array('title' => the_title_attribute('echo=0')));
				
				if ( has_post_thumbnail()) {
					echo '<p>'.$image_url.'</p>';
				}
				
				while ( have_posts() ) : the_post();
					the_content();
				endwhile; 
			?>

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Contact Form") ) : ?>			
			<form class="contactForm"  id="ajax-contact-form"  method="post" action="javascript:alert('success!');">
			   <div id="note"></div>
			   <div id="fields">
					<p>
					  <input type="text" name="name" id="name" value="" size="32" tabindex="1">
					  <label for="name"><?php _e('Name (required)', 'goodminimal'); ?></label>
					</p>
					<p>
					  <input type="text" name="email" id="email" value="" size="32" tabindex="2">
					  <label for="email"><?php _e('Email (required)', 'goodminimal'); ?></label>
					</p>
					<p>
					  <input type="text" name="subject" id="subject" value="" size="32" tabindex="3">
					  <label for="subject"><?php _e('Subject', 'goodminimal'); ?></label>
					</p>
					<p>
					  <textarea name="message" id="message" cols="55" rows="12" tabindex="4"></textarea>
					</p>
					<?php
						if ( get_option($shortname.'_recaptcha_enabled') ) : 
					?>
						<script type="text/javascript">var RecaptchaOptions = {theme : '<?php echo get_option($shortname.'_recaptcha_theme'); ?>', lang : '<?php echo get_option($shortname.'_recaptcha_lang'); ?>'};</script>
						<div style="margin-bottom:20px;">
					<?php
							echo recaptcha_get_html( $publickey, $reCaptcha_error ); 
					?>
						</div>
					<?php
						endif; 
					?>
					<p>
					  <input name="submit" type="submit" class="button shadow" id="submit" tabindex="5" value="<?php _e('Send Message', 'goodminimal');?>">
					</p>
				</div>
		    </form>
			
			<script type="text/javascript">
			/*ajax form*/
			jQuery("#ajax-contact-form").submit(function(){
				var str = jQuery(this).serialize();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo get_template_directory_uri(); ?>/functions/contact.php",
					data: str,
					success: function(msg){
						jQuery("#note").ajaxComplete(function(event, request, settings){
							if(msg == 'OK') // Message Sent? Show the 'Thank You' message and hide the form
							{
								result = '<div class="notification_ok" style="color:#cc0000; margin-bottom:30px;"><?php _e('Your message has been sent. Thank you!', 'goodminimal'); ?></div>';
								jQuery("#fields").hide();
							} else {
								result = msg;
								Recaptcha.reload();
							}
							jQuery(this).html(result);
						});
					}
				});
				return false;
			});
		</script>
			<?php endif; ?>
			
		</section>

		<section id="sidebar">
		
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Contact Sidebar") ) : ?>
			<?php endif; ?>
		
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