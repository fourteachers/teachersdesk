<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
<title><?php global $shortname, $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' ); // Add the blog name.
	$site_description = get_bloginfo( 'description', 'display' ); // Add the blog description for the home/front page.
	if ( $site_description && ( is_home() || is_front_page() ) ) { echo " | $site_description"; }

	if ( $paged >= 2 || $page >= 2 ) { echo ' | ' . sprintf( __( 'Page %s', 'goodminimal' ), max( $paged, $page ) ); } // Add a page number if necessary:
	?></title>

<meta name="viewport" content="width=device-width,initial-scale=1" />
	
<?php if (get_option($shortname.'_favicon_url')) { ?>
<link rel="shortcut icon" href="<?php echo get_option($shortname."_favicon_url"); ?>">
<?php } else { ?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
<?php } ?>

<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">

<?php
	if (get_option($shortname.'_theme_style')) {
		$theme_style = get_option($shortname.'_theme_style');
	} else {
		$theme_style = 'light-style.css';
	}

	$theme_color = str_replace('-style.css','',$theme_style);
?>
<link href="<?php echo get_template_directory_uri(); ?>/css/<?php echo $theme_style; ?>" type="text/css" rel="stylesheet" media="screen">

<?php
	if  ( (get_option($shortname."_headers_font")) && (get_option($shortname."_headers_font") != 'none' ) )
		echo ' <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.get_option($shortname."_headers_font").':regular,italic,bold,bolditalic" /> ';
	
	if  ( (get_option($shortname."_content_font")) && (get_option($shortname."_content_font") != 'none' ) )
		echo ' <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.get_option($shortname."_content_font").':regular,italic,bold,bolditalic" /> ';

	if  ( (get_option($shortname."_menu_font")) && (get_option($shortname."_menu_font") != 'none' ) )
		echo ' <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.get_option($shortname."_menu_font").':regular,italic,bold,bolditalic" /> ';			
?>

<style type="text/css">
<?php

	// get Custom CSS if exists
	if (get_option($shortname.'_custom_css')) {
		echo get_option($shortname.'_custom_css');
	}

	if  ( (get_option($shortname."_content_font")) && (get_option($shortname."_content_font") != 'none' ) ) {
		echo '
			body { font:normal 12px/21px \''.str_replace('+',' ',get_option($shortname."_content_font")).'\', Arial, Helvetica, sans-serif; }
			body { font:normal 12px/21px \''.str_replace('+',' ',get_option($shortname."_content_font")).'\', Arial, Helvetica, sans-serif; }
		';		
	}
	
	if  ( (get_option($shortname."_headers_font")) && (get_option($shortname."_headers_font") != 'none' ) ) {
		echo '
			h1, h2, h3, h4, h5, h6 { font:normal 22px/26px \''.str_replace('+',' ',get_option($shortname."_headers_font")).'\', Arial, Helvetica, sans-serif; }
			h1 a, h2 a, h3 a, h4 a, h5 a, h6 a{ font:normal 22px/26px \''.str_replace('+',' ',get_option($shortname."_headers_font")).'\', Arial, Helvetica, sans-serif; }
		';
	}
	
	if  ( (get_option($shortname."_menu_font")) && (get_option($shortname."_menu_font") != 'none' ) ) {
		echo '
			nav ul { font:normal 12px/21px \''.str_replace('+',' ',get_option($shortname."_menu_font")).'\', Arial, Helvetica, sans-serif; }
		';		
	}
?>

</style>

<link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" type="text/css" rel="stylesheet" media="screen">

<link href="<?php echo get_template_directory_uri(); ?>/css/<?php echo $theme_color; ?>-tipsy.css" type="text/css" rel="stylesheet" media="screen">
<link href="<?php echo get_template_directory_uri(); ?>/css/<?php echo $theme_color; ?>-nivo-slider.css" type="text/css" rel="stylesheet" media="screen">

<link href="<?php echo get_stylesheet_directory_uri(); ?>/style-own.css" type="text/css" rel="stylesheet" media="screen">


<!-- Place somewhere in the <head> of your document -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/flexslider/flexslider.css" type="text/css">

<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>

<script type="text/javascript" src="http://teachingdesk.com/wp-content/themes/good-minimal/js/gradeChangeTest.js"></script>
				  

<?php //if (is_home()) { ?>
<script src="<?php echo get_template_directory_uri(); ?>/flexslider/jquery.flexslider.js"></script>
<script type="text/javascript">
	$(window).load(function() {
		$('.flexslider').flexslider({		
			animation: "<?php echo get_option($shortname.'_slider_animation'); ?>",              
				//Select your animation type (fade/slide)
			slideshowSpeed: <?php echo get_option($shortname.'_slider_slideshowSpeed'); ?>,           
				//Set the speed of the slideshow cycling, in milliseconds
			animationDuration: <?php echo get_option($shortname.'_slider_animationDuration'); ?>,         
				//Set the speed of animations, in milliseconds
			slideshow: <?php if (get_option($shortname.'_slider_slideshow')) { echo get_option($shortname.'_slider_slideshow'); } else { echo 'false'; }?>,                
				//Should the slider animate automatically by default? (true/false)			
			directionNav: <?php if (get_option($shortname.'_slider_directionNav')) { echo get_option($shortname.'_slider_directionNav'); } else { echo 'false'; } ?>,             
				//Create navigation for previous/next navigation? (true/false)
			controlNav: <?php if (get_option($shortname.'_slider_controlNav')) { echo get_option($shortname.'_slider_controlNav'); } else { echo 'false'; } ?>,               
				//Create navigation for paging control of each clide? (true/false)
			keyboardNav: <?php if (get_option($shortname.'_slider_keyboardNav')) { echo get_option($shortname.'_slider_keyboardNav'); } else { echo 'false'; } ?>,              
				//Allow for keyboard navigation using left/right keys (true/false)
			touchSwipe: true,               
				//Touch swipe gestures for left/right slide navigation (true/false)
			prevText: "",   		        
				//Set the text for the "previous" directionNav item
			nextText: "",           	    
				//Set the text for the "next" directionNav item
			pausePlay: false,               
				//Create pause/play dynamic element (true/false)
			pauseText: '',             		
				//Set the text for the "pause" pausePlay item
			playText: '',               	
				//Set the text for the "play" pausePlay item
			randomize: <?php if (get_option($shortname.'_slider_randomize')) { echo get_option($shortname.'_slider_randomize'); } else { echo 'false'; } ?>,               
				//Randomize slide order on page load? (true/false)
			slideToStart: 0,                
				//The slide that the slider should start on. Array notation (0 = first slide)
			animationLoop: <?php if (get_option($shortname.'_slider_animationLoop')) { echo get_option($shortname.'_slider_animationLoop'); } else { echo 'false'; } ?>,
				//Should the animation loop? If false, directionNav will received disabled classes when at either end (true/false)
			pauseOnAction: <?php if (get_option($shortname.'_slider_pauseOnAction')) { echo get_option($shortname.'_slider_pauseOnAction'); } else { echo 'false'; } ?>,
				//Pause the slideshow when interacting with control elements, highly recommended. (true/false)
			pauseOnHover: <?php if (get_option($shortname.'_slider_pauseOnHover')) { echo get_option($shortname.'_slider_pauseOnHover'); } else { echo 'false'; } ?>
				//Pause the slideshow when hovering over slider, then resume when no longer hovering (true/false)
		});
	});
</script>
<?php //} ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-1.7.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery.tweet.js" type="text/javascript"></script> -->
<!--script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
			effect:'<?php echo get_option($shortname.'_nivo_effect'); ?>', //Specify sets like: 'fold,fade,sliceDown, random'
			animSpeed:<?php echo get_option($shortname.'_animSpeed'); ?>,
			pauseTime:<?php echo get_option($shortname.'_pauseTime'); ?>,
			directionNav:<?php if (get_option($shortname.'_directionNav')) { echo get_option($shortname.'_directionNav'); } else { echo 'false'; } ?>,
			controlNav:<?php if (get_option($shortname.'_controlNav')) { echo get_option($shortname.'_controlNav'); } else { echo 'false'; } ?>,
			keyboardNav:<?php if (get_option($shortname.'_keyboardNav')) { echo get_option($shortname.'_keyboardNav'); } else { echo 'false'; } ?>,
			pauseOnHover:<?php if (get_option($shortname.'_pauseOnHover')) { echo get_option($shortname.'_pauseOnHover'); } else { echo 'false'; } ?>
	});
});
</script-->


<script src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery.tipsy.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/libs/css3-mediaqueries.js" type="text/javascript"></script>

<!-- PrettyPhoto-->
<link  rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/<?php echo $theme_color; ?>-prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" >

<script src="<?php echo get_template_directory_uri(); ?>/js/plugins.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js" type="text/javascript"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/libs/hoverIntent.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/libs/superfish.js" type="text/javascript"></script>

<script type="text/javascript">
jQuery(function($) {
$(".sf-menu").superfish({
		delay:			200,
		speed:			'fast',
		autoArrows:		false
	});
});
</script>

</head>

<?php $body_id = ( is_home() || is_front_page() ) ? 'id="outer"' : 'id="inner"'; ?>
<body class="custom-background" <?php echo $body_id; ?>>
<div id="page">

<header id="header">
	<div class="top_social_wrap">
        <ul class="top_social_icon">
			<?php if (get_option($shortname.'_social_links_twitter')) { ?>
				<li class="twitter"><a href="<?php echo get_option($shortname.'_social_links_twitter'); ?>" class="tool_tip" title="Twitter" target="_blank">Twitter</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_facebook')) { ?>			
            <li class="facebook"><a href="<?php echo get_option($shortname.'_social_links_facebook'); ?>" class="tool_tip" title="Facebook" target="_blank">Facebook</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_dribbble')) { ?>						
            <li class="dribbble"><a href="<?php echo get_option($shortname.'_social_links_dribbble'); ?>" class="tool_tip" title="Dribbble" target="_blank">Dribbble</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_skype')) { ?>						
            <li class="skype"><a href="<?php echo get_option($shortname.'_social_links_skype'); ?>" class="tool_tip" title="Skype" target="_blank">Skype</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_dropbox')) { ?>						
            <li class="dropbox"><a href="<?php echo get_option($shortname.'_social_links_dropbox'); ?>" class="tool_tip" title="Dropbox" target="_blank">Dropbox</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_vimeo')) { ?>						
            <li class="vimeo"><a href="<?php echo get_option($shortname.'_social_links_vimeo'); ?>" class="tool_tip" title="Vimeo" target="_blank">Vimeo</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_digg')) { ?>						
            <li class="digg"><a href="<?php echo get_option($shortname.'_social_links_digg'); ?>" class="tool_tip" title="Digg" target="_blank">Digg</a></li>
			<?php } ?>
			
			<?php if (get_option($shortname.'_social_links_google')) { ?>						
            <li class="google"><a href="<?php echo get_option($shortname.'_social_links_google'); ?>" class="tool_tip" title="Google+" target="_blank">Google</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_linkedin')) { ?>						
            <li class="linkedin"><a href="<?php echo get_option($shortname.'_social_links_linkedin'); ?>" class="tool_tip" title="LinkedIn" target="_blank">LinkedIn</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_tumblr')) { ?>						
            <li class="tumblr"><a href="<?php echo get_option($shortname.'_social_links_tumblr'); ?>" class="tool_tip" title="Tumblr" target="_blank">Tumblr</a></li>
			<?php } ?>
			<?php if (get_option($shortname.'_social_links_youtube')) { ?>
            <li class="youtube"><a href="<?php echo get_option($shortname.'_social_links_youtube'); ?>" class="tool_tip" title="Youtube" target="_blank">Youtube</a></li>
			<?php } ?>			
			<?php if (get_option($shortname.'_social_links_rss')) { ?>
            <li class="rss"><a href="<?php echo get_option($shortname.'_social_links_rss'); ?>" class="tool_tip" title="RSS" target="_blank">RSS</a></li>
			<?php } ?>						
        </ul>
    </div>
    <div id="header_inner">
		<?php 
			if (get_option($shortname.'_logo')) { 
			$logo_url = get_option($shortname.'_logo');
			$logo_width = get_option($shortname.'_logo_width');
			$logo_height = get_option($shortname.'_logo_height');
  		  ?>
			<h1 id="logo"><a style="background:url(<?php echo $logo_url; ?>) no-repeat;	width:<?php echo $logo_width; ?>px; height:<?php echo $logo_height; ?>px;" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
			<?php } else { ?>
			<h1 id="logo"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
        <?php } ?>
	<div id="tagLine">
	<h2><?php echo get_bloginfo('description');?> </h2>
	</div>
    	<nav>

		    <?php
				//begin to display WP 3 Menus or default menu
				$menu_manager = get_option($shortname.'_menu_manager');
				if (!$menu_manager) {
					wp_nav_menu( array(
					'menu'              => '',
					'container'         => '',
					'container_class'   => '',
					'container_id'      => '',
					'menu_class'        => 'sf-menu',
					'menu_id'           => '',
					'echo'              => true,
					'fallback_cb'       => 'fallback_no_menu',
					'before'            => '',
					'after'             => '',
					'link_before'       => '',
					'link_after'        => '',
					'depth'             => 0,
					'walker'            => '',
					'theme_location'    => ''
					)
				);	
			} else {
		    ?>	
			  <ul class="sf-menu">	
				<li><a href="<?php echo home_url(); ?>">Home</a></li>
			  <?php	
				$page_exclusions = get_option($shortname.'_exclude_header_pages');
				$nav_menu_pages = wp_list_pages('show_home=1&sort_column=menu_order&sort_order=asc&exclude=&title_li=&echo=0');
				$nav_menu_pages = str_replace('current_page_item','current_page_item active',$nav_menu_pages);
				echo $nav_menu_pages;
			  ?>
			</ul>
			<?php } //end to check if default menu is enabled  ?>
        </nav>
    </div><!-- END: #header_inner-->
    
    <!-- Then somewhere in the <body> section -->
</header><!-- END: #header-->