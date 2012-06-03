<?php
/**
 * GoodMinimal Theme Shortcodes
*/


/* Simple Slider shortcodes */
function theme_lightbox($atts, $content = null) {
	extract(shortcode_atts(array(
		"group_id" => '',
		"thumb_url" => '',
		"big_image_url" => '',
		"video_url" => ''
	), $atts));

	if ($big_image_url) $get_custom_image_url = $big_image_url;
	if ($video_url) $get_custom_image_url = $video_url;
	if (!$get_custom_image_url) $get_custom_image_url = $thumb_url;

	return '<div style="clear:both;"><a href="'.$get_custom_image_url.'" rel="prettyPhoto[lightbox_'.$group_id.']" class="thumb"><img src="'.$thumb_url.'"></a></div>';
}
add_shortcode('lightbox', 'theme_lightbox');


/* Simple Slider shortcodes */
function theme_simple_slider($atts, $content = null) {
	extract(shortcode_atts(array(
		"id" => ''
	), $atts));

$output = '
<aside id="slider_wrap">
	<div id="slider_home">
	<div class="flexslider">
		<ul class="slides">
';

$attachment_args = array(
	'post_type' => 'attachment',
	'numberposts' => -1,       
	'post_status' => null,
	'post_parent' => $id,
	'orderby' => 'menu_order',
	'order' => 'DESC'
);

$attachments = get_posts($attachment_args);
if ($attachments) {
	foreach($attachments as $gallery ) {
		$i++;
		$imgage_attachment_url = wp_get_attachment_url( $gallery->ID);
		$gallery_thumbnail = get_the_post_thumbnail($gallery->ID, 'gallery');
		
		$output .= '
			<li>
				<a href="#"><img src="'.$imgage_attachment_url.'" /></a>
			</li> 
		';
		
	}
}

$output .= '			
		</ul>
	</div>
	</div>
	<!-- /End Full Width Slider-->
</aside><!-- END: #slider_wrap -->
';

return $output;
}
add_shortcode('simpleslider', 'theme_simple_slider');



/* Video: youtube,vimeo,flash shortcodes */
function theme_slider($atts, $content = null) {
	 
$output = '
<aside id="slider_wrap">
	<div id="slider_home">
	<div class="flexslider">
		<ul class="slides">
';


				$type = 'slider';
				$args=array(
					'post_type' => $type,
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'asc'
				);
				$temp = $wp_query;  // assign original query to temp variable for later use   
				$wp_query = null;
				$wp_query = new WP_Query($args);

				if ($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post();
				
					$custom = get_post_custom($post->ID);
					
					// get full image from featured image if was not see full image url in Portfolio
					$slider_image = get_the_post_thumbnail($post->ID, 'homepageportfolio', array('title' => the_title_attribute('echo=0')));
					
					$slider_website_url = '';
					$slider_description = '';
					$custom = get_post_custom($post->ID);
					$slider_website_url = $custom["slider_website_url"][0];
					$slider_description = $custom["slider_description"][0];
					
					$slider_description_output = '';
					if ($slider_description) {
						$slider_description_output = '<p class="flex-caption">'.$slider_description.'</p>';
					}
					
					$slider_video_url = trim($custom["slider_video_url"][0]);
					
					if ($slider_video_url == '') {
$output .= '
			<li>
				<a href="'.$slider_website_url.'">'.$slider_image.'</a>
				'.$slider_description_output.'
			</li> 
';
				} else {
$output .= '
			<li>
				<div class="video-container"><iframe id="player" src="'.$slider_video_url.'" frameborder="0"></iframe></div>
			</li> 
';
				}
					
				endwhile;
				endif; 

$output .= '			
		</ul>
	</div>
	</div>
	<!-- /End Full Width Slider-->
		
</aside><!-- END: #slider_wrap -->
';

	return $output;
}
add_shortcode('slider', 'theme_slider');



/* Video: youtube,vimeo,flash shortcodes */
function theme_video($atts, $content = null) {
	extract(shortcode_atts(array(
		"type" => '',
		"id" => '',
		"url" => '',
		"width" => '800',
		"height" => '450',
    ), $atts));

	if ($type == 'youtube') {
		$swf_url = 'http://www.youtube.com/embed/'.$id;
	} else if ($type == 'vimeo') {
		$swf_url = 'http://www.vimeo.com/moogaloop.swf?clip_id='.$id;
	} else if ($type == 'flash') {
		$swf_url = $url;
	}

	$work_image_url = '
		<div class="video-container">
			<iframe src="'.$swf_url.'" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></iframe>
		</div>
	';
	 
	return $work_image_url;
}
add_shortcode('video', 'theme_video');


function theme_portfolio_categories($atts, $content = null) {

	$output = '
		<ul>
	';
	$categories = get_categories('title_li=&orderby=name&hide_empty=0&taxonomy=portfolio_entries');
	foreach($categories as $category){
		$output .= '
			<li><a href="'.get_term_link($category->slug,'portfolio_entries').'" class="'.$category->category_nicename.'">'.$category->cat_name.'</a></li>
		';
	}

	$output .= '
		</ul>
	';

	return $output;
}
add_shortcode('portfolio_categories','theme_portfolio_categories');


function theme_contact_form($atts, $content = null) {

	$output = '
			<form class="contactForm"  id="ajax-contact-form"  method="post" action="javascript:alert(\'success!\');">
			   <div id="note"></div>
			   <div id="fields">
					<p>
					  <input type="text" name="name" id="name" value="" size="32" tabindex="1">
					  <label for="name">'.__('Name (required)', 'goodminimal').'</label>
					</p>
					<p>
					  <input type="text" name="email" id="email" value="" size="32" tabindex="2">
					  <label for="email">'.__('Email (required)', 'goodminimal').'</label>
					</p>
					<p>
					  <input type="text" name="subject" id="subject" value="" size="32" tabindex="3">
					  <label for="subject">'.__('Subject', 'goodminimal').'</label>
					</p>
					<p>
					  <textarea name="message" id="message" cols="55" rows="12" tabindex="4"></textarea>
					</p>
					<p>
					  <input name="submit" type="submit" class="button shadow" id="submit" tabindex="5" value="'.__('Send Message', 'goodminimal').'">
					</p>
				</div>
		    </form>
			
			<script type="text/javascript">
			/*ajax form*/
			jQuery("#ajax-contact-form").submit(function(){
				var str = jQuery(this).serialize();
				jQuery.ajax({
					type: "POST",
					url: "'.get_template_directory_uri().'/functions/contact.php",
					data: str,
					success: function(msg){
						jQuery("#note").ajaxComplete(function(event, request, settings){
							if(msg == \'OK\') // Message Sent? Show the \'Thank You\' message and hide the form
							{
								result = \'<div class="notification_ok" style="color:#cc0000; margin-bottom:30px;">'.__('Your message has been sent. Thank you!', 'goodminimal').'</div>\';
								jQuery("#fields").hide();
							} else {
								result = msg;
							}
							jQuery(this).html(result);
						});
					}
				});
				return false;
			});
		</script>
	';

	return $output;
}
add_shortcode('contact_form','theme_contact_form');
						

function theme_code_style($atts, $content = null) {
	return '<code>'.do_shortcode($content).'</code>';
}
add_shortcode('code_style','theme_code_style');

function theme_pre_code($atts, $content = null) {
	return '<pre><code>'.str_replace('<br />','',do_shortcode($content)).'</code></pre>';
}
add_shortcode('pre_code','theme_pre_code');


/* Get Function for Columns Shortcode */
function get_columns($atts, $content = null, $shortcodename = '') {
	extract(shortcode_atts(array(
		"type" => "" // none|featured_service
    ), $atts));

	//if (is_page_template('template-page-full-width.php')) $shortcodename = $shortcodename.'-fullwidth';
	
	//if ($type == 'featured_service') 
		$featured_service = ' featured_service';

	return '<div class="columns'.$featured_service.'">'.do_shortcode($content).'</div>';
		 
}
add_shortcode('columns', 'get_columns');

/* Get Function for Columns Shortcode */
function get_column_name($atts, $content = null, $shortcodename = '') {
	extract(shortcode_atts(array(
		"title" => "",
		"last" => "no",
		"icon" => ""
    ), $atts));


	//if (is_page_template('template-page-full-width.php')) $shortcodename = $shortcodename.'-fullwidth';
	
	if ($last == "yes")  { $class = 'class="'.$shortcodename.' last"'; $end_columns = '</div>'; } else { $class = 'class="'.$shortcodename.'"'; }
	
	
	if ($icon) $icon = '<img src="'.$icon.'" alt="'.$title.'" />';
	if ($title) { $title = '<header>'.$icon.'<h3>'.$title.'</h3></header>'; }

	return '<div '.$class.'>
			'.$title.'
			'.do_shortcode($content).'
			 </div>';
		 
}
add_shortcode('one_whole', 'get_column_name');
add_shortcode('one_half', 'get_column_name');
add_shortcode('one_third', 'get_column_name');
add_shortcode('one_fourth', 'get_column_name');
add_shortcode('one_fifth', 'get_column_name');
add_shortcode('one_sixth', 'get_column_name');
add_shortcode('two_third', 'get_column_name');
add_shortcode('three_fourth', 'get_column_name');


function theme_nav_list($atts, $content = null) {
	extract(shortcode_atts(array(
		"style" => "2"
    ), $atts));
	
	return do_shortcode(str_replace('<ul>','<ul class="side_menu">',$content)); 
	
}
add_shortcode('nav_list','theme_nav_list');	
		
		

function theme_lists($atts, $content = null) {
	extract(shortcode_atts(array(
		"style" => "2"
    ), $atts));
	if ($style == "1") return do_shortcode(str_replace('</ul>','</ol>',str_replace('<ul>','<ol>',$content)));
	if ($style == "2") return do_shortcode($content);
	if ($style == "3") return do_shortcode(str_replace('<ul>','<ul class="style_1">',$content)); 
	
	if ($style == "4") return do_shortcode(str_replace('<ul>','<ul class="style_3">',$content)); 
	if ($style == "5") return do_shortcode(str_replace('<ul>','<ul class="style_4">',$content)); 
	if ($style == "6") return do_shortcode(str_replace('<ul>','<ul class="style_5">',$content)); 
	
	if ($style == "7") return do_shortcode(str_replace('<ul>','<ul class="style_6">',$content)); 
	if ($style == "8") return do_shortcode(str_replace('<ul>','<ul class="style_7">',$content)); 
	if ($style == "9") return do_shortcode(str_replace('<ul>','<ul class="style_8">',$content)); 
	
	if ($style == "10") return do_shortcode(str_replace('<ul>','<ul class="style_9">',$content)); 
	if ($style == "11") return do_shortcode(str_replace('<ul>','<ul class="style_10">',$content)); 
	if ($style == "12") return do_shortcode(str_replace('<ul>','<ul class="style_11">',$content)); 
	
	if ($style == "13") return do_shortcode(str_replace('<ul>','<ul class="style_12">',$content)); 
	if ($style == "14") return do_shortcode(str_replace('<ul>','<ul class="style_13">',$content)); 
	if ($style == "15") return do_shortcode(str_replace('<ul>','<ul class="style_14">',$content)); 
	
}
add_shortcode('list','theme_lists');	
		
/* blockquote function */
function theme_blockquote($atts, $content = null) {
	extract(shortcode_atts(array(
		"type" => "1", // 1|2
		"author" => "",
		"url" => "",
		"urlname" => ""
    ), $atts));
	
	if ($author) $author ='<b>&mdash; '.$author.'</b>';

	if ($type == 1) {
		return '<blockquote><p>&ldquo; '.do_shortcode($content).' &rdquo;'.$author.'<a class="blockquote_href" href="'.$url.'"><strong>'.$urlname.'</strong></a></p></blockquote>';
	}
	
	if ($type == 2) {
		return '<div class="quote">
		  <div class="topbg">
			  <blockquote>
				<p>'.do_shortcode($content).'</p>
			  </blockquote>
			</div>
			<!-- end .topbg-->
			<div class="bottombg"></div>
			</div><!-- end .quote-->';
	}
	

	
}
add_shortcode('blockquote','theme_blockquote');

/* blockquote function */
function theme_testimonial($atts, $content = null) {
	extract(shortcode_atts(array(
		"img" => "",
		"authorname" => "",
		"authorinfo" => ""
    ), $atts));
	
	return '
	<div class="quote">
      <div class="topbg">
          <blockquote>
            <p>'.do_shortcode($content).'</p>
          </blockquote>
        </div>
        <!-- end .topbg-->
        <div class="bottombg"></div>
        <div class="author">
          <div class="author_img"><img src="'.$img.'" alt="Testimony" /></div>
          <span class="author_info"><strong>'.$authorname.'</strong><br />
          '.$authorinfo.'</span> </div>
        <!--end .author --> 
    </div><!-- end .quote-->';
}
add_shortcode('testimonial','theme_testimonial');
		
function get_dropcap($atts, $content = null) {
	return '<span class="drop_caps">'.do_shortcode($content).'</span>';
}
add_shortcode('dropcap', 'get_dropcap');		
		
		
		
function get_table($atts, $content = null) {
	return remove_wpautop(str_replace('<table>','<table class="table">',do_shortcode($content)));
}
add_shortcode('table', 'get_table');		
		
		
		
function theme_tabs_start($atts, $content = null) {
    extract(shortcode_atts(array(
		"tab_title" => "",
		"tab_id" => "",
		"style" => "1" // style1|style2
    ), $atts));
   
	$title_chunks = explode(",", $tab_title);
	$id_chunks = explode(",", $tab_id);
	
	
	if ($style == "1") $style_class_add = '';
	if ($style == "2") $style_class_add = '2';
	
	$tabs_output = '<ul class="tabs'.$style_class_add.'">';	
						
	for ($i=0;$i<count($title_chunks);$i++) {

		$tabs_output .= '<li><a href="#tab_'.$id_chunks[$i].'">'.$title_chunks[$i].'</a></li>';
	}
	$tabs_output .= '</ul>
					<div class="tab'.$style_class_add.'_container">';
							
	$tabs_output_end = '</div><!-- end .tabs-->';
	
	if ($style == "1") $content_output = do_shortcode($content);
	if ($style == "2") $content_output = str_replace('tab_content','tab2_content',do_shortcode($content));
	
	return $tabs_output.$content_output.$tabs_output_end;
}
add_shortcode("tabs", "theme_tabs_start");
		
		
		
function get_tabs($atts, $content = null) {
    extract(shortcode_atts(array(
		"id" => ""
    ), $atts));
	return ' 
			<div id="tab_'.$id.'" class="tab_content">
               '.do_shortcode($content).'
            </div>
		';
}		
add_shortcode('tab', 'get_tabs');



function imageresize($atts, $content = null) {
	extract(shortcode_atts(array(
		"align" => "",
		"src" => "",
		"alt" => ""
    ), $atts));

	$margin = '';

	return '<img src="'.$src.'" class="'.$align.'" alt="'.$alt.'" />';
	
}
add_shortcode('image', 'imageresize');




function theme_accordions_start($atts, $content = null) {
    extract(shortcode_atts(array(
		"type" => "1" // style1|style2
    ), $atts));
	
	if ($type == "1") return '<div class="basic" id="accordion_click">'.do_shortcode($content).'</div>';
	if ($type == "2") return '<div class="basic" id="accordion_hover">'.do_shortcode($content).'</div>';
}
add_shortcode("accordions", "theme_accordions_start");
		
		
		
function get_accordions($atts, $content = null) {
    extract(shortcode_atts(array(
		"title" => ""
    ), $atts));
	return ' 
			<a>'.$title.'</a>
			<div>
               '.do_shortcode($content).'
            </div>
		';
}		
add_shortcode('accordion', 'get_accordions');




function get_news($atts, $content = null) {
    extract(shortcode_atts(array(
		"title" => "",
		"src" => "#",
		"date" => ""
    ), $atts));
	return ' 
		<div class="columns news">        
    	<div class="one_whole">
        	<header><h4><a href="'.$src.'">'.$title.'</a></h4>
            <span class="meta">'.$date.'</span>
            </header>
        	<article><p>'.do_shortcode($content).'</p></article>
            <footer><p><a href="'.$src.'" class="button">Read More</a></p></footer>
        </div>
		</div>
		';
}		
add_shortcode('news', 'get_news');



function get_our_team($atts, $content = null) {
	
	return	'<ul class="thumb_list team">
                '.do_shortcode($content).'
			</ul>';
	
}
add_shortcode('our_team', 'get_our_team');

function get_team($atts, $content = null) {

    extract(shortcode_atts(array(
		"image" => "",
		"name" => "",		
		"position" => "",
		"last" => ""
    ), $atts));
	
	if ($last == 'yes')  $last = ' class="last"';
	
	return	'
                <li'.$last.'><img src="'.$image.'" alt="'.$name.'" />
                	<p class="meta"><b>'.$name.'</b><span>'.$position.'</span></p>
                </li>
			';
	
}
add_shortcode('team', 'get_team');



function get_services($atts, $content = null) {

    extract(shortcode_atts(array(
		"image" => "",
		"title" => "",
		"url" => ""
    ), $atts));
	
	if ($title) {
		if ($url) {
			$title_output = '<h3><a href="'.$url.'">'.$title.'</a></h3>';
		} else {
			$title_output = '<h3>'.$title.'</h3>';
		}
	
	}
	
	if ($title) {
		if ($url) {
			$image_output = '<a href="'.$url.'"><img src="'.$image.'" alt="'.$title.'"></a>';
		} else {
			$image_output = '<img src="'.$image.'" alt="'.$title.'">';
		}
	
	}
	
	
	return '
		<div class="service">			
			'.$image_output.'
			<div>
				'.$title_output.'
				<p>'.do_shortcode($content).'</p>
			</div>
		</div><!-- end service -->
	';
}		
add_shortcode('service', 'get_services');




function get_pricing_start($atts, $content = null) {

    extract(shortcode_atts(array(
		"columns" => "" // 3|4|5
    ), $atts));
	
	return '
		<div class="pricing">
			'.str_replace('#col_number#',$columns,do_shortcode($content)).'
		</div>
	';
}		
add_shortcode('pricing', 'get_pricing_start');


function get_price_column($atts, $content = null) {

    extract(shortcode_atts(array(
		"title" => "",
		"price" => "",
		"orderlink" => "",
		"buttontext" => "",
		"premium" => "no" // yes|no
    ), $atts));
	
	if ($orderlink) $order_link_output = '<span class="order"><a href="'.$orderlink.'" class="button">'.$buttontext.'</a></span>';
	
	if ($premium == 'yes') $premium_output = ' premium';
	
	if ($price) $price_output = '<div class="price"><span>'.$price.'</span></div>';
	
	return '
		<div class="col#col_number#'.$premium_output.'">
        	<div class="title_wrap"><h4>'.$title.'</h4></div>
            '.$price_output.'
            <div class="pricing_content">
                '.do_shortcode($content).'
				'.$order_link_output.'
            </div>
        </div>
	';
}		
add_shortcode('price', 'get_price_column');



















		
		
		
		
		
		
		




function theme_checkedlist($atts, $content = null) {
	return do_shortcode(str_replace('<ul>','<ul class="checkedlist">',$content));
}
add_shortcode('checkedlist','theme_checkedlist');


function theme_code($atts, $content = null) {
	return '<pre><code>'.do_shortcode($content).'</code></pre>';
}
add_shortcode('code','theme_code');


function theme_simpleborder($atts, $content = null) {
    extract(shortcode_atts(array(
		'border' 	=> '1px',
		'color'    => '#dde0d8',
        'padding'   => '2px',
    ), $atts));
	return '<img style="border:'.$border.' solid '.$color.'; padding:'.$padding.';" src="'.do_shortcode($content).'">';
}
add_shortcode('border','theme_simpleborder');


function theme_button($atts, $content = null) {
    extract(shortcode_atts(array(
	'url' => '',
	'bgcolor' => '',
	'textcolor' => '',
	'padding' => '',
	'align' => '',
    ), $atts));
	//return '<a href="'.$url.'" class="button" style="background-color:'.$bgcolor.'; color:'.$textcolor.'; padding:'.$padding.'; float:'.$align.'">'.do_shortcode($content).'</a>';
	return '<a href="'.$url.'" class="button_shortcode" style="background-color:'.$bgcolor.'; color:'.$textcolor.'; padding:'.$padding.'; float:'.$align.'">'.do_shortcode($content).'</a>';
}
add_shortcode('button','theme_button');

function theme_btn($atts, $content = null) {
    extract(shortcode_atts(array(
	'title' => '',
	'url' => '',
	'type' => 'big' //small|big
    ), $atts));
	return '<div><a href="'.$url.'" class="'.$type.'_button shadow">'.$title.'</a></div>';
}
add_shortcode('btn','theme_btn');



function theme_infobox($atts, $content = null) {
    extract(shortcode_atts(array(
	'type' => '',
    ), $atts));
	if (!$type) { $type = 'info'; }
	
	if ($type == 'info') { $image_path = get_template_directory_uri().'/images/info.png'; }
	if ($type == 'error') { $image_path = get_template_directory_uri().'/images/error.png'; }
	if ($type == 'success') { $image_path = get_template_directory_uri().'/images/success.png'; }
	if ($type == 'warning') { $image_path = get_template_directory_uri().'/images/warning.png'; }
	return '<div class="informationbox '.$type.'"><img src="'.$image_path.'"><span>'.do_shortcode($content).'</span></div>';
}
add_shortcode('infobox','theme_infobox');

function subscribeRss($atts, $content = null) {
    return '<div class="rss-box"><a href="'.get_bloginfo('rss2_url').'">'.do_shortcode($content).'</a></div>';
}
add_shortcode('subscribe', 'subscribeRss');




function related_posts($atts, $content = null) {
	extract(shortcode_atts(array(
			"count" => '5',
			"category" => '',
	), $atts));
	global $post;
	$myposts = get_posts('numberposts='.$count.'&order=DESC&orderby=post_date&category='.$category);
	$retour='<ul>';
	foreach($myposts as $post) :
			setup_postdata($post);
		 $retour.='<li><a href="'.get_permalink().'">'.the_title("","",false).'</a></li>';
	endforeach;
	$retour.='</ul> ';
	wp_reset_query();
	return $retour;
}
add_shortcode("listrelated ", "related_posts");





function get_video($atts, $content = null) {
	extract(shortcode_atts(array(
		"url" => '',
		"width" => '630',
		"height" => '385',
    ), $atts));

	$info = getimagesize($url);
	if ( (image_type_to_mime_type($info[2]) == 'application/octet-stream') or ( image_type_to_mime_type($info[2]) == 'application/x-shockwave-flash') ){
	$swf_url = str_replace('vimeo.com/','vimeo.com/moogaloop.swf?clip_id=',$url);
	$swf_url = str_replace('youtube.com/watch?v=','youtube.com/v/',$swf_url);
	
	$work_image_url = '
		<object width="'.$width.'" height="'.$height.'"><param name="movie" value="'.$swf_url.'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="'.$swf_url.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$width.'" height="'.$height.'"></embed></object>
		<p style="padding-bottom:20px;"></p>		
		';		
	} 
	return $work_image_url;
}
add_shortcode('video_temp', 'get_video');




function get_pricing($atts, $content = null) {
	extract(shortcode_atts(array(
		"title" => '',
		"bgcolor" => '#ececec',
		"price" => '',
    ), $atts));
	
	return '<div class="colorbox">
				<h3 class="colorboxtitle" style="background-color: '.$bgcolor.'; color:;">'.$title.'</h3>
				<div class="boxcontent">
				<div class="priceboxtitle">'.$price.'</div>
				'.do_shortcode($content).'
				</div>
				<!--h3 class="colorboxtitle" style="background-color: #94c400; color:;">Basic Plan</h3>
				<div class="boxcontent">
				<div class="priceboxtitle">$9.95<span>/mo</span></div>
				<ul class="bullet-check">

				<li>Proin sed sem sem.</li>
				<li>Sit amet pretium tortor.</li>
				<li>Duis eu tellus ac lectus.</li>
				<li>Mauris ultrices velit eget. Proin sollicitudin neque dolor.</li>
				</ul>
				<p><a href="#" target="_self" style="display:block; text-align:center;" class="button large"><span> Get Started </span></a>
				</div-->
			</div>';
}
add_shortcode('pricing_box', 'get_pricing');


function get_google_maps($atts, $content = null) {
   extract(shortcode_atts(array(
      "width" => '616',
      "height" => '400',
      "src" => ''
   ), $atts));
   if ($width > '616') { $width = '616'; }
   return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'" style="position: relative; top: 0; left: 0; width: 100%; margin-bottom:20px;margin-top:0px;"></iframe>';
}
add_shortcode("googlemap", "get_google_maps");


function get_free_quote($atts, $content = null) {
   extract(shortcode_atts(array(
      "url" => "#",
	  "button_title" => "Get in Touch"
   ), $atts));
   
   return '<div class="intro">
    	<div class="intro_text">
        	<h2>'.do_shortcode($content).'</h2>
        </div>
        <div class="button"><a href="'.$url.'" class="big_button shadow">'.$button_title.'</a></div>
    </div><!-- END: #intro-->';
}
add_shortcode("free_quote", "get_free_quote");



?>