<?php
class mayosis_page_colors_metabox {

	public function __construct() {

		if ( is_admin() ) {
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	public function init_metabox() {

		add_action( 'add_meta_boxes',        array( $this, 'add_metabox' )         );
		add_action( 'save_post',             array( $this, 'save_metabox' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts_styles')  );
		add_action( 'admin_footer',          array( $this, 'color_field_js' )      );

	}

	public function add_metabox() {

		add_meta_box(
			'post_colors',
			__( 'Page Colors', 'mayosis' ),
			array( $this, 'render_metabox' ),
			'page',
			'advanced',
			'default'
		);

	}

	public function render_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( 'mayosis_nonce_action', 'mayosis_nonce' );

		// Retrieve an existing value from the database.
		$mayosis_breadcrumb_color = get_post_meta( $post->ID, 'mayosis_breadcrumb_color', true );
		$mayosis_page_bg = get_post_meta( $post->ID, 'mayosis_page_bg', true );
		
		$mayosis_gradient_a = get_post_meta( $post->ID, 'mayosis_gradient_a', true );
        $mayosis_gradient_b = get_post_meta( $post->ID, 'mayosis_gradient_b', true );
		// Set default values.
		if( empty( $mayosis_breadcrumb_color ) ) $mayosis_breadcrumb_color = '#000046';
		if( empty( $mayosis_page_bg ) ) $mayosis_page_bg = '#ffffff';
		
		if( empty( $mayosis_gradient_a) ) $mayosis_gradient_a = '#460082';
		
		if( empty( $mayosis_gradient_b) ) $mayosis_gradient_b = '#00001b';

		// Form fields.
		echo '<table class="form-table">';

		echo '	<tr>';
		echo '		<th><label for="mayosis_breadcrumb_color" class="mayosis_breadcrumb_color_label">' . __( 'Breadcrumb Background', 'mayosis' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="mayosis_breadcrumb_color" name="mayosis_breadcrumb_color" class="mayosis_breadcrumb_color_field" placeholder="' . esc_attr__( '', 'mayosis' ) . '" value="' . esc_attr__( $mayosis_breadcrumb_color ) . '">';
		echo '			<p class="description">' . __( 'Select primary color', 'mayosis' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '	<tr>';
		echo '		<th><label for="mayosis_page_bg" class="mayosis_page_bg_label">' . __( 'Page Background Color', 'mayosis' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="mayosis_page_bg" name="mayosis_page_bg" class="mayosis_page_bg_field" placeholder="' . esc_attr__( '', 'mayosis' ) . '" value="' . esc_attr__( $mayosis_page_bg ) . '">';
		echo '			<p class="description">' . __( 'Select secondary color', 'mayosis' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		
			echo '	<tr>';
		echo '		<th><label for="mayosis_gradient_a" class="mayosis_gradient_a_label">' . __( 'Breadcrumb Gradient Start Color', 'mayosis' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="mayosis_gradient_a" name="mayosis_gradient_a" class="mayosis_gradient_a_field" placeholder="' . esc_attr__( '', 'mayosis' ) . '" value="' . esc_attr__( $mayosis_gradient_a ) . '">';
		echo '			<p class="description">' . __( 'Select gradient color A', 'mayosis' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';
		
				echo '	<tr>';
		echo '		<th><label for="mayosis_gradient_b" class="mayosis_gradient_b_label">' . __( 'Breadcrumb Gradient End Color', 'mayosis' ) . '</label></th>';
		echo '		<td>';
		echo '			<input type="text" id="mayosis_gradient_b" name="mayosis_gradient_b" class="mayosis_gradient_b_field" placeholder="' . esc_attr__( '', 'mayosis' ) . '" value="' . esc_attr__( $mayosis_gradient_b) . '">';
		echo '			<p class="description">' . __( 'Select gradient color B', 'mayosis' ) . '</p>';
		echo '		</td>';
		echo '	</tr>';

		echo '</table>';

	}

	public function save_metabox( $post_id, $post ) {

		// Add nonce for security and authentication.
		$nonce_name   = isset( $_POST['mayosis_nonce'] ) ? $_POST['mayosis_nonce'] : '';
		$nonce_action = 'mayosis_nonce_action';

		// Check if a nonce is set.
		if ( ! isset( $nonce_name ) )
			return;

		// Check if a nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
			return;

		// Check if the user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;

		// Check if it's not an autosave.
		if ( wp_is_post_autosave( $post_id ) )
			return;

		// Check if it's not a revision.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// Sanitize user input.
		$mayosis_new_breadcrumb_color = isset( $_POST[ 'mayosis_breadcrumb_color' ] ) ? sanitize_text_field( $_POST[ 'mayosis_breadcrumb_color' ] ) : '';
		$mayosis_new_page_bg = isset( $_POST[ 'mayosis_page_bg' ] ) ? sanitize_text_field( $_POST[ 'mayosis_page_bg' ] ) : '';

        $mayosis_gradient_a = isset( $_POST[ 'mayosis_gradient_a' ] ) ? sanitize_text_field( $_POST[ 'mayosis_gradient_a' ] ) : '';
        
         $mayosis_gradient_b = isset( $_POST[ 'mayosis_gradient_b' ] ) ? sanitize_text_field( $_POST[ 'mayosis_gradient_b' ] ) : '';
        
		// Update the meta field in the database.
		update_post_meta( $post_id, 'mayosis_breadcrumb_color', $mayosis_new_breadcrumb_color );
		update_post_meta( $post_id, 'mayosis_page_bg', $mayosis_new_page_bg );
		
		update_post_meta( $post_id, 'mayosis_gradient_a', $mayosis_gradient_a );
			
		update_post_meta( $post_id, 'mayosis_gradient_b', $mayosis_gradient_b );

	}

	public function load_scripts_styles() {

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'wp-color-picker' );

	}

	public function color_field_js() {

		// Print js only once per page
		if ( did_action( 'mayosis_page_colors_metabox_color_picker_js' ) >= 1 ) {
			return;
		}

		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#mayosis_breadcrumb_color').wpColorPicker();
				$('#mayosis_page_bg').wpColorPicker();
				$('#mayosis_gradient_a').wpColorPicker();
				$('#mayosis_gradient_b').wpColorPicker();
			});
		</script>
		<?php
		do_action( 'mayosis_page_colors_metabox_color_picker_js', $this );

	}

}

new mayosis_page_colors_metabox;