<?php
class pageoptionsMetabox {
	private $screen = array(
		'page',
	);
	private $meta_fields = array(
		array(
			'label' => 'Show Breadcrumb(with title)',
			'id' => 'breadcrumb_hide',
			'default' => 'Yes',
			'type' => 'select',
			'options' => array(
				'Yes',
				'No',
			),
		),
		array(
			'label' => 'Show Breadcrumb Menus only',
			'id' => 'breadcrumb_menu_hide',
			'default' => 'Yes',
			'type' => 'select',
			'options' => array(
				'Yes',
				'No',
			),
		),
		array(
			'label' => 'Custom Breadcrumb Title',
			'id' => 'custom_page_title',
			'type' => 'text',
			'default' => '',
		),
		array(
			'label' => 'Page Sidebar(Work in Default & Blog Author List Template)',
			'id' => 'page_sidebar',
			'default' => 'Hide',
			'type' => 'select',
			'options' => array(
				'Show',
				'Hide',
			),
		),
		array(
			'label' => 'Without Header/Footer Page BG',
			'id' => 'w_page_bg',
			'default' => 'Upload Image',
			'type' => 'media',
		),
		
		array(
			'label' => 'Breadcrumb Gradient',
			'id' => 'breadcrumb_gradient',
			'default' => 'No',
			'type' => 'select',
			'options' => array(
				'Yes',
				'No',
			),
		),
		
		array(
			'label' => 'Breadcrumb Background Image',
			'id' => 'breadcrumb_image',
			'default' => 'Upload Image ',
			'type' => 'media',
		),
		
			array(
			'label' => 'Custom Padding(Overwrite Global)',
			'id' => 'custom_padding',
			'default' => 'No',
			'type' => 'select',
			'options' => array(
				'Yes',
				'No',
			),
		),
		
		
		array(
			'label' => 'Custom Page Padding Top (i.e 20px)',
			'id' => 'custom_page_padding_top',
			'type' => 'text',
			'default' => '',
		),
		
			array(
			'label' => 'Custom Page Padding Bottom (i.e 20px)',
			'id' => 'custom_page_padding_bottom',
			'type' => 'text',
			'default' => '',
		),
	);
	
	
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'media_fields' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'pageoptions',
				__( 'Page Options', 'mayosis' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'pageoptions_data', 'pageoptions_nonce' );
		$this->field_generator( $post );
	}
	public function media_fields() {
		?><script>
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.pageoptions-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								$('input#'+id).val(attachment.url);
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
				}
			});
		</script><?php
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				case 'media':
					$input = sprintf(
						'<input style="width: 80%%" id="%s" name="%s" type="text" value="%s"> <input style="width: 19%%" class="button pageoptions-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$meta_field['id'],
						$meta_field['id']
					);
					foreach ( $meta_field['options'] as $key => $value ) {
						$meta_field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$meta_value === $meta_field_value ? 'selected' : '',
							$meta_field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}
	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['pageoptions_nonce'] ) )
			return $post_id;
		$nonce = $_POST['pageoptions_nonce'];
		if ( !wp_verify_nonce( $nonce, 'pageoptions_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}
if (class_exists('pageoptionsMetabox')) {
	new pageoptionsMetabox;
};