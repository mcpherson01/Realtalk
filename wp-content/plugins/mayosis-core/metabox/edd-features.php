<?php
 
add_action('admin_init', 'mayosis_add_meta_boxes', 1);
function mayosis_add_meta_boxes() {
	add_meta_box( 'mayosis_features_field', 'Products Features', 'mayosis_repeatable_meta_box_display', 'download', 'normal', 'default');
}

function mayosis_repeatable_meta_box_display() {
	global $post;

	$mayosis_features_field = get_post_meta($post->ID, 'mayosis_features_field', true);

	wp_nonce_field( 'mayosis_repeatable_meta_box_nonce', 'mayosis_repeatable_meta_box_nonce' );
	?>
	<script type="text/javascript">
	jQuery(document).ready(function( $ ){
		$( '#add-row' ).on('click', function() {
			var row = $( '.empty-row.screen-reader-text' ).clone(true);
			row.removeClass( 'empty-row screen-reader-text' );
			row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
			return false;
		});
  	
		$( '.remove-row' ).on('click', function() {
			$(this).parents('tr').remove();
			return false;
		});
	});
	</script>
  
	<table id="repeatable-fieldset-one" width="100%">
	<thead>
		<tr>
			<th width="40%">Name</th>
			<th width="40%">Description</th>
			<th width="8%"></th>
		</tr>
	</thead>
	<tbody>
	<?php
	
	if ( $mayosis_features_field ) :
	
	foreach ( $mayosis_features_field as $field ) {
	?>
	<tr>
		<td><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>
	
	
		<td><input type="text" class="widefat" name="description[]" value="<?php if ($field['description'] != '') echo esc_attr( $field['description'] ); ?>" /></td>
	
		<td><a class="button remove-row" href="#">Remove</a></td>
	</tr>
	<?php
	}
	else :
	// show a blank one
	?>
	<tr>
		<td><input type="text" class="widefat" name="name[]" /></td>
	
	
		<td><input type="text" class="widefat" name="description[]" /></td>
	
		<td><a class="button remove-row" href="#">Remove</a></td>
	</tr>
	<?php endif; ?>
	
	<!-- empty hidden one for jQuery -->
	<tr class="empty-row screen-reader-text">
		<td><input type="text" class="widefat" name="name[]" /></td>
	
		
		<td><input type="text" class="widefat" name="description[]" /></td>
		  
		<td><a class="button remove-row" href="#">Remove</a></td>
	</tr>
	</tbody>
	</table>
	
	<p><a id="add-row" class="button" href="#">Add Another</a></p>
	<?php
}

add_action('save_post', 'mayosis_repeatable_meta_box_save');
function mayosis_repeatable_meta_box_save($post_id) {
	if ( ! isset( $_POST['mayosis_repeatable_meta_box_nonce'] ) ||
	! wp_verify_nonce( $_POST['mayosis_repeatable_meta_box_nonce'], 'mayosis_repeatable_meta_box_nonce' ) )
		return;
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	
	if (!current_user_can('edit_post', $post_id))
		return;
	
	$old = get_post_meta($post_id, 'mayosis_features_field', true);
	$new = array();
	
	$names = $_POST['name'];
	$descriptions = $_POST['description'];
	
	$count = count( $names );
	
	for ( $i = 0; $i < $count; $i++ ) {
		if ( $names[$i] != '' ) :
			$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
			
		
			if ( $descriptions[$i] == '' )
				$new[$i]['description'] = '';
			else
				$new[$i]['description'] = stripslashes( $descriptions[$i] ); // and however you want to sanitize
		endif;
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'mayosis_features_field', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'mayosis_features_field', $old );
}
?>