<?php
/*
 * Category selector in submission form
 */
 if (isset($_GET['task']) && $_GET['task'] === 'edit-product' ||isset($_GET['task']) && $_GET['task'] === 'new-product') {
  add_action('wp_enqueue_scripts', 'cat_selector_additional_scripts');  // Category dropdown
}
function cat_selector_additional_scripts()
{
  wp_enqueue_script('category_dropdown_js', plugin_dir_url( __FILE__ ) . '../js/category-dropdown.js', array('jquery'), '0.0.1', true);
//  wp_enqueue_script('jquery_ui_lib', 'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', array('jquery'), '0.0.1', true);
  // via select2
  wp_enqueue_style('select2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css');
  wp_enqueue_script('select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js', array(), '0.0.1', true);

}

add_action('category_dropdown_autocomplete', 'dropdown_autocomplete_field', 10, 3);

function dropdown_autocomplete_field($form, $save_id, $field)
{
  echo do_shortcode('[dropdown_autocomplete_input]');
}

add_shortcode('dropdown_autocomplete_input', 'get_dropdown_autocomplete_input');

function get_dropdown_autocomplete_input()
{
  $html = '';
//  $html .= '<div class="fes-el download_tag category_autocomplete">		<div class="fes-label">
//			    <label for="category_autocomplete">Products Category<span class="fes-required-indicator">*</span></label>
//				</div>
//				<div class="fes-fields">
//					<input class="textfield fes-required-field category_autocomplete" id="category_autocomplete" type="text" data-required="1" data-type="text" name="category_autocomplete" size="40" placeholder="Start typing...">
//				</div>
//		  </div>';
  return $html;
}


/*
 * Upload button for Cover Photo Url field in Dashboard > Profile
 */
if (isset($_GET['task']) && $_GET['task'] === 'profile'||isset($_GET['task']) && $_GET['task'] === 'new-product'){
  add_action('wp_enqueue_scripts', 'upload_button_scripts');
}

function upload_button_scripts()
{
  wp_enqueue_script('upload_button_js', plugin_dir_url( __FILE__ ). '../js/upload-button.js', array('jquery'), '0.0.1', true);
}

/*
 * Add parents categories on create/update download product
 */
add_action('save_post', 'action_save_download_product', 10, 3);

function get_term_id_by_slug($item, $taxonomy = 'download_category')
{
  return get_term_by('slug', $item, $taxonomy)->term_id;
}


add_action('fes_save_submission_form_values_after_save', 'fes_formsds', 10, 3);

function fes_formsds($inst) {
    action_save_download_product($inst->save_id, get_post($inst->save_id), true);
}

/*
 *  Add parents categories
 */
function action_save_download_product($post_ID, $post, $update)
{
  $slug = 'download';

  if ($slug !== $post->post_type) {
    return;
  }

  $download_categories = get_the_terms($post_ID, 'download_category');

  if (!$download_categories) {
    return;
  }

  $categories = [];

  foreach ($download_categories as $download_category) {
    array_push($categories, $download_category->term_id);
  }


  foreach ($download_categories as $category) {
    if ($category->parent === 0) {
      continue;
    }

    $parents_categories_id = array_map('get_term_id_by_slug', array_filter(explode('/', get_term_parents_list($category->parent, 'download_category', [link => false, format => 'slug'])), function ($value) {
      return $value !== '';
    }));

    if (count($parents_categories_id) === 0) {
      continue;
    }

    foreach ($parents_categories_id as $id) {
      array_push($categories, $id);
    }
  }

  wp_set_post_terms($post_ID, $categories, 'download_category');
}

function mayosis_download_vendor_dashboard_menu( $menu_items ) {
	$menu_items['purchase_history'] = array(
		"icon" => "",
		"task" => array( 'purchase_history' ),
		"name" => __( 'Purchases', 'mayosis' ), // the text that appears on the tab
	);
	$menu_items['following_items'] = array(
		"icon" => "",
		"task" => array( 'following_items' ),
		"name" => __( 'Following Items', 'mayosis' ), // the text that appears on the tab
	);
	return $menu_items;
}
add_filter( 'fes_vendor_dashboard_menu', 'mayosis_download_vendor_dashboard_menu' );

// make the new tab work
function mayosis_download_task_response( $custom, $task ) {
	if ( $task == 'purchase_history' ) {
		$custom = 'purchase_history';
	}
	
	if ( $task == 'following_items' ) {
		$custom = 'following_items';
	}
	return $custom;
}
add_filter( 'fes_signal_custom_task', 'mayosis_download_task_response', 10, 2 );

// the content associated with your new tab
function mayosis_purchase_history_tab_content() {
	?>
	<div class="vendor-dashboard-boxes">
	    <h4><?php esc_html_e('Purchase History','mayosis');?></h4>
<?php echo do_shortcode('[purchase_history]');?>
</div>

	<?php
}
add_action( 'fes_custom_task_purchase_history','mayosis_purchase_history_tab_content' );


function mayosis_following_items_tab_content() {
	?>
	<div class="vendor-dashboard-boxes">
	    <h4><?php esc_html_e('Follwing Items','mayosis');?></h4>
 <?php echo do_shortcode('[following_posts]'); ?>
</div>

	<?php
}
add_action( 'fes_custom_task_following_items','mayosis_following_items_tab_content' );
