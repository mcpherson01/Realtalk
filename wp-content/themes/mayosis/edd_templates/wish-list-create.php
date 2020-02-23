<?php
/**
 * Create Wish List template
*/
?>

<?php
/**
 * Add new list button
 * Only shows if guests are allowed to create lists
*/
if ( edd_wl_allow_guest_creation() ) : ?>
<form action="<?php echo esc_url( add_query_arg( 'created', true ) ); ?>" class="wish-list-form" method="post">
	<p>
		<label for="list-title"><?php _e( 'Title:', 'mayosis' ); ?></label>
		<input type="text" name="list-title" id="list-title">
	</p>
	<p>
		<label for="list-description"><?php _e( 'Description:', 'mayosis' ); ?></label>
		<textarea name="list-description" id="list-description" rows="3" cols="30"></textarea>
	</p>
	<p>
		<select name="privacy">
			<option value="private"><?php _e( 'Private - only viewable by you', 'mayosis' ); ?></option>
			<option value="publish"><?php _e( 'Public - viewable by anyone', 'mayosis' ); ?></option>
		</select>
	</p>
	<p>
		<input type="submit" value="<?php _e( 'Create', 'mayosis' ); ?>" class="button">
	</p>

	<input type="hidden" name="submitted" id="submitted" value="true">

	<?php wp_nonce_field( 'list_nonce', 'list_nonce_field' ); ?>
</form>
<?php endif; ?>
