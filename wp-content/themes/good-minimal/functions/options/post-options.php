<?php
global $shortname;
$meta_box_post = array(
    'id' => 'my-meta-box',
    'title' => 'Select Sidebar',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
		array(
            'name' => 'Select Sidebar',
            'desc' => 'Select sidebar and info in Widgets.',
            'id' => 'current_sidebar',
            'type' => 'custom_sidebars'
        )			
    )
);
add_action('admin_menu', 'mytheme_add_box_post');

// Add meta box
function mytheme_add_box_post() {
    global $meta_box_post;
    
    add_meta_box($meta_box_post['id'], $meta_box_post['title'], 'mytheme_show_box_post', $meta_box_post['page'], $meta_box_post['context'], $meta_box_post['priority']);
}

// Callback function to show fields in meta box
function mytheme_show_box_post() {
    global $meta_box_post, $post;
	global $shortname;
    
    // Use nonce for verification
    echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
    echo '<table class="form-table">';

    foreach ($meta_box_post['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        
        echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong></label></th>',
                '<td>';
        switch ($field['type']) {
            case 'text':
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />', '
', $field['desc'];
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '
', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
           case 'custom_sidebars':
			
				$custom = get_post_custom($post->ID);
				$current_sidebar = $custom["current_sidebar"][0];	

               	echo '<select name="'.$field['id'].'">';	
				echo '<option value=""></option>';		
				
				
				$get_custom_options = get_option($shortname.'_sidebar_list');
				$m = 0;
				for($i = 1; $i <= 200; $i++) 
				{
					if ($get_custom_options[$shortname.'_sidebar_list_url_'.$i])
					{	
						if ( $current_sidebar == $get_custom_options[$shortname.'_sidebar_list_url_'.$i] ) { 
							?>
								<option selected value='<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?></option>";
							<?php	
						} else {
							?>
								<option value='<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?>'>&nbsp;&nbsp;&nbsp;<?php echo $get_custom_options[$shortname.'_sidebar_list_url_'.$i]; ?></option>";
							<?php 
						}
					}
				}
				echo '</select>';
				echo '<br/><span>'.$field['desc'].'</span>';
                break;					
        }
        echo     '<td>',
            '</tr>';
    }
    
    echo '</table>';
}

add_action('save_post', 'mytheme_save_data_post');

// Save data from meta box
function mytheme_save_data_post($post_id) {
    global $meta_box_post;
    
    // verify nonce
    if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    
    foreach ($meta_box_post['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
?>