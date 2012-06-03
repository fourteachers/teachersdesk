<?php
$themename = 'GoodMinimal';

function goodminimal_widgets_init() {

register_sidebar(array(
	'name' => 'Homepage Widgets Area',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Blog Sidebar',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Blog Single Page Sidebar',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Page Sidebar',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Portfolio Sidebar',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Contact Sidebar',
	'before_widget' => '<div class="sidebox">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));

register_sidebar(array(
	'name' => 'Contact Form',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h2>',
	'after_title' => '</h2>'
));


register_sidebar(array(
	'name' => 'Footer Column 1',
	'before_widget' => '<div style="margin-bottom:30px">',
	'after_widget' => '</div>',
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

register_sidebar(array(
	'name' => 'Footer Column 2',
	'before_widget' => '<div style="margin-bottom:30px">',
	'after_widget' => '</div>',
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

register_sidebar(array(
	'name' => 'Footer Column 3',
	'before_widget' => '<div style="margin-bottom:30px">',
	'after_widget' => '</div>',
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

register_sidebar(array(
	'name' => 'Footer Column 4',
	'before_widget' => '<div style="margin-bottom:30px">',
	'after_widget' => '</div>',
	'before_title' => '<h4>',
	'after_title' => '</h4>'
));

global $shortname;
$get_custom_options = get_option($shortname.'_sidebar_list');
$m = 0;
$sidebarsCount = $get_custom_options['sidebarsCount'];
for($i = 1; $i <= $sidebarsCount; $i++) {
	if ($get_custom_options[$shortname.'_sidebar_list_url_'.$i]) {
		$sidebar_name = $get_custom_options[$shortname.'_sidebar_list_url_'.$i];
		if ( function_exists('register_sidebar') )
			register_sidebar(array(
				'id' => strtolower(str_replace(' ','-',$sidebar_name)),
				'description' => $sidebar_name,		
				'name' => $sidebar_name,
				'before_widget' => '<div class="sidebox">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));	
		$m = $m + 1;
	}
}	

}
/** Register sidebars by running goodminimal_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'goodminimal_widgets_init' );

/** Register sidebars by running theme_widgets_init() on the widgets_init hook. */ 
function my_unregister_widgets() {
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_RSS' );
} 
add_action( 'widgets_init', 'my_unregister_widgets' );
?>