<?php
/* goodminimal functions and definitions */
/* Set the content width based on the theme's design and stylesheet. Used to set the width of images and content. */
if ( ! isset( $content_width ) )
	$content_width = 640;

/* Run goodminimal_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'goodminimal_setup' );

if ( ! function_exists( 'goodminimal_setup' ) ):

	function goodminimal_setup() {

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 250, 200, true ); 
		add_image_size( 'homepageslider', 954, 452, true );
		add_image_size( 'homepageportfolio', 182, 121, true );
		add_image_size( 'portfolio_one', 220, 148, true );
		add_image_size( 'portfolio_two', 419, 249, true );
		add_image_size( 'portfolio_three', 272, 182, true );
		add_image_size( 'portfolio_four', 198, 118, true );
		add_image_size( 'page_sidebar_header', 616, 216, true );
		add_image_size( 'post_single_page', 616, 359, true );
		add_image_size( 'page_fullwidth_header', 864, 216, true );
		add_image_size( 'blog_listing', 110, 110, true );
		add_image_size( 'last_comments', 50, 50, true );
		add_image_size( 'popular_recent_posts', 39, 39, true );

		if (!is_admin()) {
			wp_deregister_script('jquery');
			wp_register_script('jquery',  'https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js', false, '1.6.2');
			wp_enqueue_script('jquery');
		}
		
		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Make theme available for translation. Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'goodminimal', TEMPLATEPATH . '/languages' );
		$locale = get_locale();
		$locale_file = TEMPLATEPATH . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );		
		
		// This theme uses wp_nav_menu() in one location.
		add_theme_support('nav-menus');
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				array(
				  'header_menu' => 'Header Navigation'
				)
			);
		}

		
		// Style the visual editor.
		add_editor_style();
		
		// This theme allows users to set a custom background
		add_custom_background();
	}
endif;



function goodminimal_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'goodminimal_page_menu_args' );

function goodminimal_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'goodminimal_excerpt_length' );


function goodminimal_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'goodminimal_remove_gallery_css' );

if ( ! function_exists( 'goodminimal_comment' ) ) :

function goodminimal_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div class="comment comment" id="comment-<?php comment_ID(); ?>">
		
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'goodminimal' ); ?></em>
			<br />
		<?php endif; ?>

		
		<h5><?php comment_author_link(); ?></h5>
        <span class="date"><?php
			/* translators: 1: date, 2: time */
			printf( __( '%1$s', 'goodminimal' ), get_comment_date() ); ?></a><?php edit_comment_link( __( '(Edit)', 'goodminimal' ), ' ' );
		?></span>
        <p><?php comment_text(); ?></p>
		<?php comment_reply_link( array_merge( $args, array( 'class' => 'comment-reply-link', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		  
	</div>
	</li>

	<?php
	endswitch;
}
endif;


function goodminimal_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'goodminimal_remove_recent_comments_style' );

if ( ! function_exists( 'goodminimal_posted_on' ) ) :

function goodminimal_posted_on() {	
	?>
	<span class="meta"><?php _e( 'Written by', 'goodminimal' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author(); ?></a> <?php _e( 'on', 'goodminimal' ); ?> <a href="<?php echo get_month_link(get_the_time('Y'),get_the_time('m')).get_the_time('d'); ?>"><?php echo get_the_date('M jS, Y'); ?></a> <?php _e( 'in', 'goodminimal' ); ?> <?php the_category(', '); ?> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span> 	
	<?php
}
endif;

if ( ! function_exists( 'goodminimal_posted_in' ) ) :

function goodminimal_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'goodminimal' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'goodminimal' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'goodminimal' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/***********************************************************************************************/
/***********************************************************************************************/
/***********************************************************************************************/
/******************************* BEGIN ADMIN PANEL *********************************************/
/***********************************************************************************************/
/***********************************************************************************************/
/***********************************************************************************************/

define('ADMIN_JS',  get_template_directory_uri() . '/functions/options/js' );
define('ADMIN_CSS',  get_template_directory_uri() . '/functions/options/css' );
define('ADMIN_OPTIONS', TEMPLATEPATH . '/functions/options');
define('GENERAL_FUNCTIONS', TEMPLATEPATH . '/functions');

function admin_scripts() {
	//wp_enqueue_script('color-picker', ADMIN_JS.'/jscolor/jscolor.js', array('jquery'));
	wp_enqueue_script('slider-table', ADMIN_JS .'/slider_table.js', false, '1.0.0');
	wp_enqueue_script('slide-toggle-menu', ADMIN_JS .'/slide_toggle_menu.js', false, "1.0.0");
	wp_enqueue_script('slide-add-remove', ADMIN_JS .'/slider_add_remove.js', false, "1.0.0");
	wp_enqueue_style( 'slider-css', ADMIN_CSS .'/slider_table_style.css', false, '1.0.0', 'screen' );
}
add_action('admin_enqueue_scripts', 'admin_scripts');


// Load Posts Custom Fields in Posts
require_once(ADMIN_OPTIONS . '/post-options.php');

// Load Posts Custom Fields in Pages
require_once(ADMIN_OPTIONS . '/page-options.php');

// Load portfolio
require_once(ADMIN_OPTIONS . '/portfolio-options.php');

// Load Products
//require_once(ADMIN_OPTIONS . '/products-options.php');

// Load Slider Custom Fields
require_once(ADMIN_OPTIONS . '/slider-options.php');


// Load WP Options
require_once(GENERAL_FUNCTIONS . '/custom.php');

// Load WP-Pagenavi
require_once(GENERAL_FUNCTIONS . '/wp-pagenavi.php');

// Load Shortcodes
require_once( GENERAL_FUNCTIONS . '/shortcodes.php');

// Load Widgets
require_once( GENERAL_FUNCTIONS . '/widgets.php');
require_once( GENERAL_FUNCTIONS . '/widgets/recent-posts-widget.php');
require_once( GENERAL_FUNCTIONS . '/widgets/popular-posts-widget.php');
require_once( GENERAL_FUNCTIONS . '/widgets/twitter.php');
require_once( GENERAL_FUNCTIONS . '/widgets/flickr.php');
require_once( GENERAL_FUNCTIONS . '/widgets/social-links.php');
require_once( GENERAL_FUNCTIONS . '/widgets/search.php');
require_once( GENERAL_FUNCTIONS . '/widgets/categories.php');


$themename = "GoodMinimal";
$shortname = "gm";

/* Get CSS files into a array list */
$css_styles = array();
if(is_dir(TEMPLATEPATH . "/css/")) 
{
	if($open_dirs = opendir(TEMPLATEPATH . "/css/")) 
	{
		while(($style = readdir($open_dirs)) !== false) 
		{
			if(stristr($style, "superfish") == false) 
			//if(stristr($style, "reset") == false) 
			{
				if(stristr($style, "-style.css") !== false) 
				{
					$css_styles[] = $style;
				}
			}
		}
	}
}
$css_styles_list = $css_styles;

/* Get Pages into a drop-down list */
/*$pages = get_pages();
$pagetomenu = array();
foreach($pages as $apag) 
{
	$pagetomenu[$page->ID] = $page->post_title;
}*/


$css_styles = array("light-style.css","dark-style.css");
$theme_fonts = array("Arvo","Bentham","Cantarell","Crimson+Text","Cuprum","Dancing+Script","Droid+Sans","Droid+Serif","Goudy+Bookletter+1911","Josefin+Sans","Kreon","Lobster","Nobile","PT+Sans","Philosopher","Quattrocento","Raleway","Tangerine","Ubuntu","Yanone+Kaffeesatz",'none');
$FlexEffects = array("fade","slide");

/* Control Panel options */
$options = array (
	
	array( "type" => "options_begin"),
	
	/* General Theme Settings */
	array( "name" => "General Theme Settings",
	"type" => "toggle"),
	
	array( "type" => "open"),
		
	array(	"name" => "Theme Stylesheet",
			"desc" => "Please choose one of the Theme skins here.",
			"id" => $shortname."_theme_style",
			"type" => "select",
			"options" => $css_styles),
	
	array(	"name" => "Logo URL",
			"desc" => "Logo width:170px; height:40px. If the input field is left blank then the themes default logo gets applied.<br>
			Paste the full URL path to your logo e.g. 'http://www.yourdomain.com/images/logo.jpg'.",
            "id" => $shortname."_logo",
            "type" => "text_image_url"),

	array(	"name" => "Logo Image Width",
			"desc" => "Enter logo image width.",
            "id" => $shortname."_logo_width",
            "type" => "text_image_url",
			"std" => ""),

	array(	"name" => "Logo Image Height",
			"desc" => "Enter logo image height, maximum logo height 64px.",
            "id" => $shortname."_logo_height",
            "type" => "text_image_url",
			"std" => ""),
	
	array(	"name" => "Favicon URL",
			"desc" => "Enter your site favicon url.",
            "id" => $shortname."_favicon_url",
            "type" => "text_image_url",
			"std" => ""),		
			
	array(	"name" => "Activate default WP Menu",
			"desc" => "Check to deactivate <strong>Menu Manager</strong> - Powered by WordPress 3+ system and activate classic menu with pages.",
            "id" => $shortname."_menu_manager",
            "type" => "checkbox"),

	array(	"name" => "Custom CSS",
			"desc" => "Please enter Custom CSS",
            "id" => $shortname."_custom_css",
            "type" => "textarea"),	
			
	array(    "type" => "close"),
	
	// Fonts
	array( "name" => "Site Fonts",
		    "type" => "toggle"),
	array( "type" => "open"),
	array(	"name" => "Select font for headers",
			"desc" => "Please select font for headers (h1,h2,h3,h4,h5,h6).",
			"id" => $shortname."_headers_font",
			"type" => "select",
			"options" => $theme_fonts),
	array(	"name" => "Select font for content",
			"desc" => "Please select font for content.",
			"id" => $shortname."_content_font",
			"type" => "select",
			"options" => $theme_fonts),
	array(	"name" => "Select font for menu",
			"desc" => "Please select font for menu.",
			"id" => $shortname."_menu_font",
			"type" => "select",
			"options" => $theme_fonts),
	array(    "type" => "close"),
	
	/* HomePage Settings */
	array( "name" => "Portfolio Settings",
	"type" => "toggle"),
	array(	"type" => "open"),
	array(	"name" => "Hide Portfolio from Homepage",
			"type" => "checkbox",
			"id" => $shortname."_hide_portfolio_homepage"),
	array(  "name" => "Portfolio items per page",
			"desc" => "Enter how many items to display in Portfolio page.",
            "id" => $shortname."_portfolio_items_count",
			"std" => "12",
            "type" => "text"),			
	array(	"name" => "Assign Portfolio Page to a Category",
			"desc" => "Select a Page to display Portfolio Category",
			"id" => $shortname."_portfolio_add",
			"type" => "portfolio_add"),					
	array(    "type" => "close"),
	
	
	/* Blog Settings */
	array( "name" => "Blog Settings",
	"type" => "toggle"),
	array(	"type" => "open"),
	array(  "name" => "Blog posts per page",
			"desc" => "Enter how many posts to display in Blog listing.",
            "id" => $shortname."_blog_items_count",
			"std" => "5",
            "type" => "text"),			
	array(	"name" => "Assign Blog Page to a Category",
			"desc" => "Select a Page to display Blog Category",
			"id" => $shortname."_blog_add",
			"type" => "blog_add"),					
	array(    "type" => "close"),	
	
	
	/* Flex Slider Settings */
	array( "name" => "Slider Settings",
			"type" => "toggle"),
	array(	"type" => "open"),
	array(	"name" => "effect",
			"id" => $shortname."_slider_animation",
			"desc" => "Select your animation type (fade/slide).",
			"std" => "fade",
			"type" => "select_tweenType",
			"options" => $FlexEffects),
	array(  "name" => "slideshowSpeed",
			"desc" => "Set the speed of the slideshow cycling, in milliseconds.",
			"id" => $shortname."_slider_slideshowSpeed",
			"type" => "text",
			"std" => "3000"),	
	array(  "name" => "animationDuration",
			"desc" => "Set the speed of animations, in milliseconds.",
			"id" => $shortname."_slider_animationDuration",
			"type" => "text",
			"std" => "600"),
	array(	"name" => "slideshow",
			"desc" => "Should the slider animate automatically by default?",
            "id" => $shortname."_slider_slideshow",
            "type" => "checkbox"),			
	array(	"name" => "directionNav",
			"desc" => "Create navigation for previous/next navigation?",
            "id" => $shortname."_slider_directionNav",
            "type" => "checkbox"),
	array(	"name" => "controlNav",
			"desc" => "Create navigation for paging control of each clide?",
            "id" => $shortname."_slider_controlNav",
            "type" => "checkbox"),
	array(	"name" => "keyboardNav",
			"desc" => "Allow for keyboard navigation using left/right keys.",
            "id" => $shortname."_slider_keyboardNav",
            "type" => "checkbox"),
	array(	"name" => "randomize",
			"desc" => "Set the slides to load randomize.",
            "id" => $shortname."_slider_randomize",
            "type" => "checkbox"),			
	array(	"name" => "animationLoop",
			"desc" => "Should the animation loop?",
            "id" => $shortname."_slider_animationLoop",
            "type" => "checkbox"),
	array(	"name" => "pauseOnAction",
			"desc" => "Pause the slideshow when interacting with control elements, highly recommended.",
            "id" => $shortname."_slider_pauseOnAction",
            "type" => "checkbox"),
	array(	"name" => "pauseOnHover",
			"desc" => "Pause the slideshow when hovering over slider, then resume when no longer hovering.",
            "id" => $shortname."_slider_pauseOnHover",
            "type" => "checkbox"),
	array(  "type" => "close"),
	
	
	/* HomePage Settings */
	array( "name" => "Socials Links",
	"type" => "toggle"),
	array(	"type" => "open"),
	array(	"name" => "Twitter url",
			"desc" => "Enter Twitter url for your username.",
			"id" => $shortname."_social_links_twitter",
			"type" => "text"),
	array(	"name" => "Facebook url",
			"desc" => "Enter Facebook url for your username.",
			"id" => $shortname."_social_links_facebook",
			"type" => "text"),
	array(	"name" => "Dribbble url",
			"desc" => "Enter Dribbble url for your username.",
			"id" => $shortname."_social_links_dribbble",
			"type" => "text"),			
	array(	"name" => "Skype url",
			"desc" => "Enter Skype url for your username.",
			"id" => $shortname."_social_links_skype",
			"type" => "text"),	
			
	array(	"name" => "Dropbox url",
			"desc" => "Enter Dropbox url for your username.",
			"id" => $shortname."_social_links_dropbox",
			"type" => "text"),			
	array(	"name" => "Vimeo url",
			"desc" => "Enter Vimeo url for your username.",
			"id" => $shortname."_social_links_vimeo",
			"type" => "text"),						
	array(	"name" => "Digg url",
			"desc" => "Enter Digg url for your username.",
			"id" => $shortname."_social_links_digg",
			"type" => "text"),	
			
	array(	"name" => "Google+ url",
			"desc" => "Enter Google+ url for your username.",
			"id" => $shortname."_social_links_google",
			"type" => "text"),
	array(	"name" => "LinkedIn url",
			"desc" => "Enter LinkedInd url for your username.",
			"id" => $shortname."_social_links_linkedin",
			"type" => "text"),
	array(	"name" => "Tumblr url",
			"desc" => "Enter Tumblr url for your username.",
			"id" => $shortname."_social_links_tumblr",
			"type" => "text"),
	array(	"name" => "Youtube url",
			"desc" => "Enter Youtube url for your username.",
			"id" => $shortname."_social_links_youtube",
			"type" => "text"),
	array(	"name" => "RSS url",
			"desc" => "Enter RSS url for your username.",
			"id" => $shortname."_social_links_rss",
			"type" => "text"),
			
	array(    "type" => "close"),

	
	/* Sidebars */
	array( "name" => "Sidebars",
			"type" => "toggle"),	
			
	array( "type" => "open"),
	
	array(	"name" => "Add, Edit, Remove sidebars",
			"desc" => "Add new sidebars for posts, portfolio items, pages anh when edit pages, posts thene select the sidebar.<br/>In widgets you can add info for this sidebar.<br/><br/>
						<strong>Note:</strong> To delete one sidebar, just leave it empty and click button <strong>Save changes</strong>.",
			"id" => $shortname."_sidebar_list",
			"type" => "sidebar_list"),	
			
	array(  "type" => "close"),	
	
	
	
	/* Contact settings */
	array( "name" => "Contact Settings",
			"type" => "toggle"),	
			
	array( "type" => "open"),
	
	array(	"name" => "Your email",
		"desc" => "Enter your email for contact form.",
		"id" => $shortname."_contact_admin_email",
		"type" => "text"),

	array(	"name" => "Enable reCAPTCHA",
		"desc" => "Check to enable reCAPTCHA in contact form.",
		"id" => $shortname."_recaptcha_enabled",
		"type" => "checkbox"),

	array(	"name" => "reCAPTCHA public key",
			"desc" => "Enter reCAPTCHA public key.",
            "id" => $shortname."_recaptcha_publickey",
            "type" => "text"),
			
	array(	"name" => "reCAPTCHA private key",
			"desc" => "Enter reCAPTCHA private key.",
            "id" => $shortname."_recaptcha_privatekey",
            "type" => "text"),
			
	array(  "type" => "close"),		

			
	/* Footer Theme Settings */
	array( "name" => "Footer Settings",
	"type" => "toggle"),
	
	array( "type" => "open"),
	
	array(	"name" => "Tracking Code",
			"desc" => "Enter the tracking code. Where can I find my tracking code from within my Google Analytics account? Click <a href='http://www.google.com/support/analytics/bin/answer.py?hl=en&answer=55603' target='_blank'>here</a>.",
			"id" => $shortname."_tracking_code",
			"type" => "textarea"),

	array(	"name" => "Footer (Copyright)",
			"desc" => "Enter in the company that is copyrighting site content. This will show up in the footer.",
			"id" => $shortname."_footer_copyright",
			"type" => "textarea",
			"std" => "Copyright 2011. All Rights Reserved."),

	array(    "type" => "close"),
	
	array( "type" => "options_end"),
	
);	
	
function mytheme_add_admin() {

    global $themename, $shortname, $options;

    if ( $_GET['page'] == basename(__FILE__) ) {
    
        if ( 'save' == $_REQUEST['action'] ) {
				
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($options as $value) 
				{
                    if( isset( $_REQUEST[ $value['id'] ] ) ) 
					{ 
						update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
					} else { 
						delete_option( $value['id'] ); 
					} 
				}

				/* Updates unlimited sidebars settings */
				$sidebarsCount = 0;
				foreach ($_POST as $key => $value) 
				{
					if ( preg_match("/sidebar_list_url_/", $key) ) 
					{
						if ($value != '') $sidebarsCount = $sidebarsCount +1;
					}
				}		
				foreach ($_POST as $key => $value) 
				{
					if ( preg_match("/sidebar_list_url_/", $key) ) 
					{	
						if ($value != '') $options_sidebars_custom[$key] = $value;
					}	
					
					$options_sidebars_custom['sidebarsCount'] = $sidebarsCount;
					
					delete_option( 'gm_sidebar_list');
					update_option( 'gm_sidebar_list', $options_sidebars_custom);					
				}

				// Update option 'portfolio_page_id' Portfolio ID to Category for unlimited portfolio subcategories
				foreach ($_POST as $key => $value) 
				{
					if ( preg_match("/portfolio_to_cat_/", $key) ) 
					{	
						if ($value != '') $portfolio_items[$key] = $value;
					}	
									
					delete_option( $shortname.'_portfolio_page_id');
					update_option( $shortname.'_portfolio_page_id', $portfolio_items);					
				}
							

				// Update option 'blog_page_id' Blog Post ID to Category for unlimited Blog Pages
				foreach ($_POST as $key => $value) 
				{
					if ( preg_match("/blog_to_cat_/", $key) ) {	
						if ($value != '') $blog_items[$key] = $value;
					}
					delete_option( $shortname.'_blog_page_id');
					update_option( $shortname.'_blog_page_id', $blog_items);
				}							
				
                header("Location: themes.php?page=functions.php&saved=true");
                die;

        } else if ( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_menu_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function categories_for_gallery($shortname,$page_id) {

	//get selected page_id for portfolio
	$get_custom_options = get_option($shortname.'_gallery_page_id'); 
	$get_page_id  = $get_custom_options['gallery_id_'.$page_id];
	
	//get category name
	$get_category_name = get_option($shortname.'_gallery_id_'.$page_id);
	
	$output = '';
	$output .= '<select name="gallery_id_'.$page_id.'" class="postform selector">';	
	$output .= '<option value="0">&nbsp;&nbsp;&nbsp;Select category</option>';	
	$categories = get_categories();			
	foreach ($categories as $cat) 
	{
		$selected_option = $cat->cat_ID;
		if ($get_page_id == $selected_option) { 
			$output .= '<option selected value="'.$cat->cat_ID.'">&nbsp;&nbsp;&nbsp;'.$cat->cat_name.'</option>';
		} else {
			$output .= '<option value="'.$cat->cat_ID.'">&nbsp;&nbsp;&nbsp;'.$cat->cat_name.'</option>';
		}	
	}	
	$output .= '</select>';	
	
	return $output;
}



function check_gallery_template($pagetemplate = '') {
	global $wpdb;
	global $shortname;
	$output = '';
	$output .= '<table>';
	$sql = "select post_id from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";
	$result = $wpdb->get_results($sql);
	foreach ($result as $value){
		$page_id = $value->post_id;
		$page_data = get_page( $page_id );
		$title = $page_data->post_title; 
		$output .=  '<tr><td>Select Category to display in  Page <strong>'.$title.'</strong></td><td>&nbsp;:&nbsp;</td><td>'.categories_for_gallery($shortname,$page_id).'</td></tr>';
	}
	$output .= '</table>';
	
	return $output;
}


function display_contact_content($values_id,$shortname,$blog_or_news)
{
	$get_blog_name = get_option($shortname.'_display_'.$blog_or_news.'_content');

	echo '<select name="'.$values_id.'" class="postform selector">';	
	echo '<OPTGROUP LABEL="Pages">';
	echo '<option value="0">Select Page</option>';		
	global $post;
	$myposts = get_pages();
	foreach($myposts as $post) : setup_postdata($post);
		$selected_option = $post->ID;		
		if ( $get_blog_name == $selected_option ) { 
		?>
			<option selected value='<?php echo $post->ID; ?>'>&nbsp;&nbsp;&nbsp;<?php the_title(); ?></option>";
		<?php	
		}
		if ( $get_blog_name != $selected_option ) { 
		?>
			<option value='<?php  echo $post->ID; ?>'>&nbsp;&nbsp;&nbsp;<?php the_title(); ?></option>";
		<?php 
		}
	endforeach;
	echo '</OPTGROUP>';	
	echo '</select>';
}

function display_news_content($values_id,$shortname,$blog_or_news)
{
	$get_blog_name = get_option($shortname.'_display_'.$blog_or_news.'_content');

	
	if ($blog_or_news == 'news'){
		$get_news_name = get_option($shortname.'_display_'.$blog_or_news.'_content_to_cat');
		echo '<select name="'.$values_id.'_to_cat" class="postform selector">';	
		echo '<OPTGROUP LABEL="Categories">';
		echo '<option value="0">Select category</option>';			
		$categories = get_categories();			
		foreach ($categories as $cat) 
		{
			$selected_option = $cat->cat_ID;
			if ($get_news_name == $selected_option) { 
			?>
			
				<option selected value='<?php echo $cat->cat_ID; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $cat->cat_name; ?></option>			
			<?php
			} else {
			?>
			
				<option value='<?php echo $cat->cat_ID; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $cat->cat_name; ?></option>
			<?php 
			}	
		};			
		echo '</OPTGROUP>';	
		echo '</select>';	
	}			
}

/* Exclude/Include pages from/in header menu */
function exclude_header_pages($values_id,$shortname)
{
	$htmlselected = '';
	$get_custom_options = get_option($shortname.'_exclude_header_pages');
	
	$page_items = explode(',',$get_custom_options);
	$count_pages = count($page_items);
	foreach($page_items as $page_item){
		$page_item_list[] = $page_item;
	}

	$n = 0;
	$n2 = 777;
	global $post;
	$arguments = array(
		'child_of' =>  $n,
		'parent' => $n
	);

	//$pages = get_pages();
	$myposts = get_pages($arguments);
	foreach($myposts as $post) : setup_postdata($post);
		$selected_option = get_permalink($post->ID);

		$checked_page = '';
		for($i=0;$i<$count_pages;$i++)
		{
			if ($page_item_list[$i] == $post->ID) { $checked_page = 'checked="yes"'; }
		}
		$n = $n + 1;
		if ($n == 10) { echo '<br>'; $n = 1;}
		echo '<p style="display:inline; padding: 0 10px 0 3px;">&raquo;<input '.$checked_page.' onClick="getSelectValue_pages('.$post->ID.');" name="'.$post->ID.'" type="checkbox" value="'.the_title().'"/></p>';
	endforeach;	
	
	echo '<p><input type="hidden" readonly="readonly" style="padding-top: 4px; width: 400px;"  name="'.$values_id.'" id="'.$values_id.'" value="'.$get_custom_options.'" type="text"></p>';
}

function display_gallery_portfolio_services($values_id,$shortname,$gallery_or_portfolio)
{
	$get_blog_name = get_option($shortname.'_display_'.$gallery_or_portfolio.'_content');

	$get_gallery_name = get_option($shortname.'_display_'.$gallery_or_portfolio.'_content_to_cat');
	echo '<select name="'.$values_id.'_to_cat" class="postform selector">';	
	echo '<OPTGROUP LABEL="Categories">';
	echo '<option value="0">&nbsp;&nbsp;&nbsp;Select category</option>';	
	$categories = get_categories();			
	foreach ($categories as $cat) 
	{
		$selected_option = $cat->cat_ID;
		if ($get_gallery_name == $selected_option) { 
		?>
		
			<option selected value='<?php echo $cat->cat_ID; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $cat->cat_name; ?></option>			
		<?php
		} else {
		?>
		
			<option value='<?php echo $cat->cat_ID; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $cat->cat_name; ?></option>
		<?php 
		}	
	};			
	echo '</OPTGROUP>';	
	echo '</select>';		
}

/* Exclude categories from Blog */
function exclude_categories($values_id,$shortname)
{
	$get_custom_options = get_option($shortname.'_exclude_categories');
	
	$cat_items = explode(',',$get_custom_options);
	$count_cat = count($cat_items);
	foreach($cat_items as $cat_item){
		$cat_item_list[] = $cat_item;
	}

	$categories = get_categories('hide_empty=0');
	foreach($categories as $cat)
	{
		$checked_cat = '';
		for($i=0;$i<$count_cat;$i++)
		{
			if ($cat_item_list[$i] == $cat->cat_ID) { $checked_cat = 'checked="yes"'; }
		}
		$n = $n + 1;
		if ($n == 10) { echo '<br>'; $n = 1;}
		echo $cat->cat_name ; 
		echo '<p style="display:inline; padding: 0 10px 0 3px;">&raquo;<input '.$checked_cat.' onClick="getSelectValue_cats('.$cat->cat_ID.');" name="'.$cat->cat_ID.'" type="checkbox" value="'.$cat->cat_name.'"/></p>';
	};
	
	echo '<p><input type="hidden" readonly="readonly" style="padding-top: 4px; width: 400px;"  name="'.$values_id.'" id="'.$values_id.'" value="'.$get_custom_options.'" type="text"></p>';
}


/* mytheme_admin function */
function mytheme_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) {	echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>'; }
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';   
?>
<div class="wrap">

<?php screen_icon('options-general'); ?>
<h2><?php echo $themename; ?> settings</h2>

<form method="post" action="">
<?php foreach ($options as $value) { 
    
	switch ( $value['type'] ) {
	
	
		case "options_begin":
		?>
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/functions/options/js/jquery.tzCheckbox/jquery.tzCheckbox.css" />
		<?php break;
		
		case "options_end":
		?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/functions/options/js/jquery.tzCheckbox/jquery.tzCheckbox.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/functions/options/js/jquery.tzCheckbox/script.js"></script>
		<?php break;
		
		case "open":
		?>
        <table width="100%" border="0" style="background-color:#ffffff; padding:10px;border:1px double #f1f1f1;">  
		<?php break;
		
		case "close":
		?>	
		<tr>
			<td coslapan="2">
			<p class="submit">
				<input name="save" type="submit" value="Save changes" />    
				<input type="hidden" name="action" value="save" />
			</p>
			</td>
		</tr>
        </table><br />     		
		</div>
		</div>
		<?php break;
		
		case "title":
		?>
		<table width="100%" border="0" style="background-color:#f1f1f1; padding:5px 10px;"><tr>
        	<td colspan="2"><h3 style="color:#414141"><?php echo $value['name']; ?></h3></td>
        </tr>       
		<?php break;
		
		case 'text_image_url':
		?>  
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo trim(str_replace('\t','',str_replace('\\', '', get_option( $value['id'] )))); } else { echo $value['std']; } ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;

		case 'text':
		?>      
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo trim(str_replace('\t','',str_replace('\\', '', get_option( $value['id'] )))); } else { echo $value['std']; } ?>" /></td>
        </tr>

        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;
		
		case "text_translate":
		?>      
        <tr>
			<td colspan="2" width="100%"><h1><?php echo $value['name']; ?></h1><?php echo $value['desc']; ?><hr></td>
        </tr>
		
        <tr>
            <td></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>      
		<?php break;
	
		case 'textarea':
		?>      
        <tr>
            <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php 
				if ( get_option( $value['id'] ) != "") { 
						echo trim(str_replace('\t','',str_replace('\\', '', get_option( $value['id'] ))));
				} else { 
					echo $value['std']; 
				} 
			?></textarea></td>
         </tr>
        <tr>
            <td><small><?php echo $value['desc']; ?></small></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;
				
		case 'select':
		?>
		<tr>
			<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
			<td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php 
			echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php 
			if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } 
			else if (get_option( $value['id'] ) == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
			</td>
		</tr>
		<tr>
			<td><small><?php echo $value['desc']; ?></small></td>
		</tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php
		break;
		
		case 'select_tweenType':
		?>
		<tr>
			<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
			<td width="80%">
				<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td><small><?php echo $value['desc']; ?></small></td>
		</tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php
		break;
      
		case "checkbox":
		?>
		<tr>
			<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
            <td width="80%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; } else { if ( $value['std'] === "true" ){ $checked = "checked=\"checked\""; } else { $checked = ""; } } ?>
                        <input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
			</td>
        </tr>          
        <tr>
			<td><small><?php echo $value['desc']; ?></small></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
        <?php 		
		break;
		
				
		
		case "radio":
		?>
		<tr>
			<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
			<td width="80%">
				<label><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="<?php echo $value['value']; ?>" <?php echo $selector; ?> <?php if (get_option( $value['id']) == $value['value'] || get_option( $value['id']) == ""){echo 'checked="checked"';}?> /> <?php echo $value['desc']; ?></label><br />
				<label><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>_2" type="radio" value="<?php echo $value['value2']; ?>" <?php echo $selector; ?> <?php if (get_option( $value['id']) == $value['value2']){echo 'checked="checked"';}?> /> <?php echo $value['desc2']; ?></label>
			</td>
		</tr>
		<tr>
			<td><small><?php //echo $value['desc']; ?></small></td>
		</tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td>
		</tr>
		<!--/tr-->
		<?php
		break;
			
		case "radio_doted":
		?>
		<tr>
			<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
			<td width="80%">
				<label><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="<?php echo $value['value']; ?>" <?php echo $selector; ?> <?php if (get_option( $value['id']) == $value['value'] || get_option( $value['id']) == ""){echo 'checked="checked"';}?> /> <?php echo $value['desc']; ?></label><br />
				<label><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>_2" type="radio" value="<?php echo $value['value2']; ?>" <?php echo $selector; ?> <?php if (get_option( $value['id']) == $value['value2']){echo 'checked="checked"';}?> /> <?php echo $value['desc2']; ?></label><br />
				<!--label><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>_3" type="radio" value="<?php echo $value['value3']; ?>" <?php echo $selector; ?> <?php if (get_option( $value['id']) == $value['value3']){echo 'checked="checked"';}?> /> <?php echo $value['desc3']; ?></label><br /-->
				

			</td>
		</tr>
		<tr>
			<td><small><?php //echo $value['desc']; ?></small></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<!--/tr-->
		<?php
		break;			
 
 		case "slider_control_panel":
		?>
		<tr>
			<td colspan="2">
			<table>
				<tr>
					<td width="41%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
					<td width="59%"></td>
				</tr>
				<tr>
					<td><small><?php echo $value['desc']; ?></small></td>
				</tr>
			
			</td>
		</tr>
		<?php 
		break;
		
		case 'dottedline':
		?>
        <tr>
            <td></td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:0px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;

		case 'displaycontactcontent':
		?>        
        <tr>
            <td>
				<strong><?php echo $value['name']; ?></strong>
			</td>
			<td><?php display_contact_content($value['id'],$shortname,'contact'); ?>
				<br><small><?php echo $value['desc']; ?></small>
			</td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;	

		case 'displaynewscontent':
		?>        
        <tr>
            <td>
				<strong><?php echo $value['name']; ?></strong>
			</td>
			<td><?php display_news_content($value['id'],$shortname,'news'); ?>
				<br><small><?php echo $value['desc']; ?></small>
			</td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;	

		case 'exclude_header_pages':
		?>
        <tr>
            <td>
				<strong><?php echo $value['name']; ?> </strong>
			</td>
			<td id="show_hide_pg">
				<?php exclude_header_pages($value['id'],$shortname); ?><small><?php echo $value['desc']; ?></small>
			</td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;

		case 'exclude_categories':
		?>
        <tr>
            <td>
				<strong><?php echo $value['name']; ?> </strong>
			</td>
			<td id="show_hide_pg">
				<?php exclude_categories($value['id'],$shortname); ?><small><?php echo $value['desc']; ?></small>
			</td>
        </tr>
		<tr>
			<td colspan="2" style="margin-bottom:5px;border-bottom:0px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td>
		</tr>
		<?php 
		break;
		
		case "toggle":
		$i++;
		?>
		<div class="slideToggle" style="background-color:#f1f1f1; padding:5px 10px;">
		<div><h3 style="cursor:pointer; font-size:1.1em; margin:0;	font-weight:bold; color:#264761; padding:10px">&rarr; <?php echo $value['name']; ?></h3>
		</span><div class="clearfix"></div></div>
		<div class="settings">
		<?php break;

		
		case "sidebar_list":
		?>	
		
		<table class="slider-box" id="demo">
			<thead>
			<tr>
				<th style="text-align:left;width:10%;">N.&nbsp;&nbsp;&nbsp;</th>
				<th style="text-align:left;width:90%;">Sidebar Name</th>

			</tr>
			</thead>
			<tbody>
			<?php
			$get_custom_options = get_option($shortname.'_sidebar_list');
			$m = 0;
			for($i = 1; $i <= 200; $i++) 
			{
				if ($get_custom_options[$shortname.'_sidebar_list_url_'.$i])
				{
					echo '
					<tr class="sidebars" rel="sidebar_'.($m+1).'"><td>'.($m+1).'</td>
					<td><input style="width: 100%;" name="'.$value['id'].'_url_'.($m+1).'" id="'.$value['id'].'_url_'.($m+1).'" 
						type="text" value="'.$get_custom_options[$shortname.'_sidebar_list_url_'.$i].'"></td>
					</tr>
					';
					$m = $m + 1;
				}
			}
			?>
			<p><?php echo $value['desc']; ?></p>
			<p>
				<input type="button" value="Add New Sidebar" onclick="addRowToTable();" />
				<!--input type="button" value="Remove" onclick="removeRowFromTable2();" /-->
			</p>
		</tbody>
		</table>
		<?php
		break;				
		
		
		case 'colorpicker':
		
			$val = $value['std'];
			$stored  = get_option($value['id']);
			if ($stored != "") { $val = $stored; }
		?>
		
       <tr>
            <td width="25%" rowspan="2" valign="top"><?php echo $value['name']; ?></td>
            <td width="75%">
			<?php
				echo '<input style="width:70px;" class="color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
			?>

			</td>
         </tr>
        <tr>
            <td style="padding:0 0 20px 0;"><small><?php echo $value['desc']; ?></small></td>
        </tr>
		<?php 
		break;			

		case "portfolio_add":
		?>
		<tr>
            <td colspan="2">
				<strong><?php echo $value['name']; ?></strong>
				<!--br><small><?php echo $value['desc']; ?></small-->	
			</td>
        </tr>
		<tr>
			<td colspan="2"><?php echo is_pagetemplate_portfolio('portfolio-%'); ?></td>
		</tr>
		<?php
		break;		

		case "blog_add":
		?>
		<tr>
            <td colspan="2">
				<strong><?php echo $value['name']; ?></strong>
				<!--br><small><?php echo $value['desc']; ?></small-->	
			</td>
        </tr>
		<tr>
			<td colspan="2"><?php echo is_pagetemplate_blog('blog%'); ?></td>
		</tr>
		<?php
		break;		
		
} 
}
?>
</form>

<?php
}
add_action('admin_menu', 'mytheme_add_admin');


// check if is portfolio page template function
function is_pagetemplate_portfolio($pagetemplate = '') {
	global $wpdb;
	global $shortname;
	$output = '';
	$output .= '<table><tr><td colspan="3"><small>To show from all categories leave "Select category"</small></td></tr>';
	$sql = "select post_id from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";
	$result = $wpdb->get_results($sql);
	foreach ($result as $value){
		$page_id = $value->post_id;
		$page_data = get_page( $page_id );
		$title = $page_data->post_title; 
		$output .=  '<tr><td>Page <strong>'.$title.'</strong></td><td>&nbsp;:&nbsp;</td><td>'.display_categories($shortname,$page_id).'</td></tr>';
	}
	$output .= '</table>';
	
	return $output;
}


// fisplay categories function					
function display_categories($shortname,$page_id) {
	//get selected page_id for portfolio
	
	$get_custom_options = get_option($shortname.'_portfolio_page_id'); 
	$get_page_id  = $get_custom_options['portfolio_to_cat_'.$page_id];	
	
	//get category name
	$get_category_name = get_option($shortname.'_portfolio_categories_'.$page_id);
	
	$output = '';
	$output .= '<select name="portfolio_to_cat_'.$page_id.'" class="postform selector">';	
	$output .= '<option value="0">&nbsp;&nbsp;&nbsp;Select category</option>';
	
	//list terms in a given taxonomy (useful as a widget for twentyten)
	$taxonomy = 'portfolio_entries';
	$tax_terms = get_terms($taxonomy);

	foreach ($tax_terms as $tax_term) {
		
		$selected_option = $tax_term->term_id;
		
		if ($get_page_id == $selected_option) { 
			$output .= '<option selected value="'.$tax_term->term_id.'">&nbsp;&nbsp;&nbsp;'.$tax_term->name.'</option>';
		} else {
			$output .= '<option value="'.$tax_term->term_id.'">&nbsp;&nbsp;&nbsp;'.$tax_term->name.'</option>';
		}
	}
	
	$output .= '</select>';	
	
	return $output;
}


function display_blog_categories($shortname,$page_id) {

	$get_custom_options = get_option($shortname.'_blog_page_id'); 
	$get_page_id  = $get_custom_options['blog_to_cat_'.$page_id];	
	$cat_option = '<select name="blog_to_cat_'.$page_id.'" class="postform selector">';	
	$cat_option .= '<option value="0">All Categories</option>';
	$categories = get_categories(); 
	foreach ($categories as $category) {
		$selected_option = $category->term_id;		
		if ($get_page_id == $selected_option) { 
			$cat_option .= '<option selected value="'.$category->term_id.'">';
		} else {
			$cat_option .= '<option value="'.$category->term_id.'">';
		}
		$cat_option .= $category->cat_name;
		$cat_option .= '</option>';
	}
	$cat_option .= '</select>';
	
	return $cat_option;
}

// check if is blog page template function
function is_pagetemplate_blog($pagetemplate = '') {
	global $wpdb;
	global $shortname;
	$output = '';
	$output .= '<table>';	
	$sql = "select post_id from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";
	$result = $wpdb->get_results($sql);
	foreach ($result as $value){
		$page_id = $value->post_id;
		$page_data = get_page( $page_id );
		$title = $page_data->post_title; 
		$output .=  '<tr><td>Page <strong>'.$title.'</strong></td><td>&nbsp;:&nbsp;</td><td>'.display_blog_categories($shortname,$page_id).'</td></tr>';
	}
	$output .= '</table>';
	wp_reset_query();
	return $output;
}

// Breadcrumbs function code
function goodminimal_breadcrumbs() {
 

  if ( !is_home() && !is_front_page() || is_paged() ) {
 

 
    global $post;
	global $shortname;
    $home = home_url();
	echo '<li><a href="'.$home.'">'._e('Home', 'goodminimal').'</a> / ';
 
    if ( is_category() ) {
      global $wp_query;
	  global $shortname;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo '<li class="last">'._('Archive by category','goodminimal').' &#39;';
      single_cat_title();
	  echo '&#39;</li>';
 
    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> / ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> / </li>';
      echo '<li class="last">'.get_the_time('d').'</li>';
 
    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> / </li>';
      echo '<li class="last">'.get_the_time('F').'</li>';
 
    } elseif ( is_year() ) {
      echo '<li class="last">' . get_the_time('Y') . '</li>';
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); 
	  $cat = $cat[0]; 
	  
	  
	  if (!$cat) { 
		if( get_post_type() == 'portfolio' ) { 		

		} 
	  } else {
	  	echo '<li>'.get_category_parents($cat, TRUE, ' ' . $delimiter . ' ').' / </li>';
	  }
      echo '<li class="last">';
	  the_title();
	  echo '</li>';
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> / </li>';
      echo '<li class="last">';
      the_title();
      echo '</li>';
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo '<li class="last">';
      the_title();
      echo '</li>';
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a> / </li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo '<li class="last">';
      the_title();
      echo '</li>';
 
    } elseif ( is_search() ) {
      echo '<li class="last">' ._e( 'Search Results for', 'goodminimal' ).' &#39;' . get_search_query() . '&#39;' . '</li>';
 
    } elseif ( is_tag() ) {
      echo '<li class="last">' ._e( 'Posts tagged', 'goodminimal' ).' &#39;';
      single_tag_title();
      echo '&#39;' . '</li>';
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo '<li class="last">' ._e( 'Articles posted by', 'goodminimal' ) . $userdata->display_name . '</li>';
 
    } elseif ( is_404() ) {
      echo '<li class="last">' ._e( 'Error 404', 'goodminimal' ) . '</li>';
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }

 
  }
}

function fallback_no_menu() {
	global $shortname;
	echo '<ul class="sf-menu">	
			<li><a href="'.home_url().'">Home</a></li>';
			
	$page_exclusions = get_option($shortname.'_exclude_header_pages');
	$nav_menu_pages = wp_list_pages('show_home=1&sort_column=menu_order&sort_order=asc&exclude=&title_li=&echo=0');
	$nav_menu_pages = str_replace('current_page_item','current_page_item active',$nav_menu_pages);
	echo $nav_menu_pages;
	echo '</ul>';
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes(){
	return 'class="nextspostslink"';
}

function remove_wpautop($content) { 
    $content = do_shortcode( shortcode_unautop($content) ); 
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
    return $content;
} 

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
	$indent = str_replace('current-page-item','active',$indent);
    $output .= "\n$indent<ul>\n";
  }
}

/* Add 'active' class name where is 'current_page_item' class name */
function add_last_item_class($strHTML) {
	
	if ((!is_single()) && (!is_archive()) && (!is_search()) ) {
		$intPos = strpos($strHTML,'current_page_item');
		if ($intPos) { 
			$temp_strHTML = substr($strHTML,0,$intPos) . ' active ' . substr($strHTML,$intPos,strlen($strHTML)); 
		} else { $temp_strHTML = substr($strHTML,0,$intPos) . substr($strHTML,$intPos,strlen($strHTML)); }
	} else { 
		$intPos = strpos($strHTML,'current_page_item_not_existing');
		$temp_strHTML = substr($strHTML,0,$intPos) . substr($strHTML,$intPos,strlen($strHTML));
	}
	
	$temp_strHTML = str_replace('menu-item ','',$temp_strHTML);
	$temp_strHTML = str_replace(' class="sub-menu"','',$temp_strHTML);
	$temp_strHTML = str_replace('menu-item-type-post_type menu-item-object-page ','',$temp_strHTML);		
	echo $temp_strHTML;

}
add_filter('wp_nav_menu','add_last_item_class');



//GALLERY shortcode
//Example:
//[gallery id="" width="" height=""]
remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'theme_gallery');
function theme_gallery($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => "",
		"width" => "80",
		"height" => "80"
    ), $atts));

	$attachment_args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,       
		'post_status' => null,
		'post_parent' => $id,
		'orderby' => 'menu_order',
		'order' => 'DESC'
	);

	if ($id) {
		
		$output_pagination = '
			<style>
				#gallery-1 {
					margin: auto;
				}
				#gallery-1 .gallery-item {
					float: left;
					margin-top: 10px;
					margin-right: 20px;
					text-align: center;
					width: auto;
				}
				#gallery-1 img {
					border: 2px solid #cfcfcf;
				}
				#gallery-1 .gallery-caption {
					margin-left: 0;
				}
			</style>
		';
	
		$output_pagination .= '
			<div id="gallery-1" class="gallery galleryid-500 gallery-columns-3 gallery-size-thumbnail">
		';
		
		$site_url_images = get_site_url();
		$attachments = get_posts($attachment_args);
		if ($attachments) {
			foreach($attachments as $gallery ) {
				$i++;
				//$imgage_attachment_url =  str_replace($site_url_images,'',wp_get_attachment_url( $gallery->ID));
				$imgage_attachment_url = wp_get_attachment_url( $gallery->ID);
				//$gallery_thumbnail = get_the_post_thumbnail($gallery->ID, 'gallery');
				
				$output_pagination .= '
					<dl class="gallery-item">
					  <dt class="gallery-icon"> <a href="'.$imgage_attachment_url.'" rel="prettyPhoto[gallery_'.$id.']" title="'.get_the_title($gallery->ID).'"><img src="'.get_bloginfo('template_url').'/functions/timthumb.php?src='.$imgage_attachment_url.'&amp;w='.$width.'&amp;h='.$height.'&amp;zc=1" /></a></dt>
					</dl>
				';
			}
		}

		$output_pagination .= '
				<br style="clear: both" />
				<br style="clear: both;" />
			</div>
		';

		return $output_pagination;
	} else return 'Wrong gallery shortcode format...';
}
add_shortcode('gallery','theme_gallery');


//disable admin bar for site
add_filter( 'show_admin_bar', '__return_false' );
// Adding Shortcodes to Sidebar Widgets
add_filter('widget_text', 'do_shortcode');

?>