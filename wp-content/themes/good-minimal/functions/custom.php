<?php
/* Last Comments on HomePage */
function last_comments($number) {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,150) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT ".$number;

	$comments = $wpdb->get_results($sql);
	$output = '';
	$site_url_images = get_site_url();
	foreach ($comments as $comment) {

		$image_url = get_the_post_thumbnail($comment->ID, 'last_comments', array('class' => 'alignleft border', 'title' => the_title_attribute('echo=0')));
		
		$output .= '<li class="clearfix"> <a href="'.get_permalink($comment->ID).'">'.$image_url.' '.$comment->post_title.'</a> <span class="comment">'.strip_tags($comment->com_excerpt).'<span class="date-comment">On <a href="'.get_permalink( $comment->comment_ID ).'#">'.get_comment_date( 'M jS, Y', $comment->comment_ID ).'</a></span></span></li>';
		
	}
	echo $output;
}

/* HomePage left box under 3 columns */
if(!function_exists('getPageContent'))
{
	function getPageContent($pageId,$useTitle)
	{
		if(!is_numeric($pageId))
		{
			return '<h2>About Us</h2><p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante.</p>';
		}
		global $wpdb;
		$sql_query = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
		' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
		$posts = $wpdb->get_results($sql_query);
		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				if (empty($post->post_excerpt)) {
					$post->post_excerpt = explode(" ",strrev(substr(($post->post_content), 0, 700)),2);
					$post->post_excerpt = strrev($post->post_excerpt[1]);
					$post->post_excerpt.= "...";
				}

				if ($useTitle == 1) $output .= '<h2>'.$post->post_title.'</h2>';
				$output .= '<p>'.$post->post_excerpt.'</p>';
			}
			return $output;
		}
	}
}

// Get posts Custom Fields
function get_wp_options($option_name, $info, $default = false){
	GLOBAL $shortname;
	$value = get_option($shortname.$option_name);
	if (!$value) { $value = $info; }
	($value == false) ? $default : $value;
	return $value;
}

// Get posts for homepage 3 columns
function get_columns_data($post_id,$selected_type,$max_char,$column_number){
	GLOBAL $shortname;
	$query_post = get_post($post_id);	
	$title = $query_post->post_title;
	$content = $query_post->post_content;
	$permalink = get_permalink($post_id);
	$columnimage = get_post_meta($post_id, $shortname.'_small_image_257x57', true);
	if($columnimage != ''){ 
		$alt_text = 'no image';
		$img_src = '<img src="'.$columnimage.'" alt="'.$alt_text.'" />';
	} else {
		$alt_text = $title;
		$img_src = '';		
	}							
	
	$column_readmore_text = get_option($shortname.'_column'.$column_number.'_readmore_text');	
	if ($column_readmore_text == false) $column_readmore_text = 'Read more' ;
	
	$content=str_replace(']]>', ']]&gt;', $content);
	$content = strip_tags($content);
	if ($max_char != 0)	$content = substr($content,0,$max_char);		

	
	$intro_text = get_option($shortname.'_column'.$column_number.'_intro_text');
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), array( 267, 124 ), false, '' );
	echo $image_src[0];
	echo '
	           	<h3>'.$title.'</h3>
                <span class="intro_text">'.$intro_text.'</span>
				<img src="'.$image_src[0].'" alt="'.$title.'" />				
				<p>'.$content.'</p>
                <div class="link_btn"><a href="'.$permalink.'"><span></span>Read More</a></div>
	';
	
}

// Get excerpt content
function excerpt_content($text, $excerpt_length, $removep) {
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
	if ($removep) { $text = strip_tags($text, '<p>'); $text = strip_tags($text, '</p>'); }
	$text = str_replace('<p>-', '<p>&#151;',$text);
	$words = explode(' ', $text, $excerpt_length + 1);
	if (count($words)> $excerpt_length) {
		array_pop($words);
		array_push($words, '.');
		$text = implode(' ', $words);
	}
	return $text;
}
?>