<?php
class productoptionsMetabox {
	private $screen = array(
		'download',
	);
	private $meta_fields = array(
		array(
			'label' => 'Demo Link',
			'id' => 'demo_link',
			'default' => '',
			'type' => 'text',
		),
		array(
			'label' => 'Video Url',
			'id' => 'video_url',
			'default' => '',
			'type' => 'text',
		),
		array(
			'label' => 'Audio Url',
			'id' => 'audio_url',
			'default' => '',
			'type' => 'text',
		),
		
			array(
			'label' => 'Font Url',
			'id' => 'sample_font_url',
			'default' => '',
			'type' => 'text',
		),
		array(
			'label' => 'Version',
			'id' => 'product_version',
			'default' => '',
			'type' => 'text',
		),
		
		array(
			'label' => 'File Included',
			'id' => 'file_type',
			'default' => '',
			'type' => 'text',
		),
		
		array(
			'label' => 'File Size',
			'id' => 'file_size',
			'default' => '',
			'type' => 'text',
		),
		
		array(
			'label' => 'Compatible With',
			'id' => 'compatible_with',
			'default' => '',
			'type' => 'text',
		),
	
		array(
			'label' => 'Documentation',
			'id' => 'documentation',
			'default' => '',
			'type' => 'text',
		),
		
		
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'productoptions',
				__( 'Product Information', 'mayosis' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'high'
			);
		}
	}
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'productoptions_data', 'productoptions_nonce' );
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
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
		echo '<div class="mayosis-meta-admin">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<div class="mayosis-admin-col-6">'.$label.'<div class="mayosis-input-box-admin">'.$input.'</div></div>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['productoptions_nonce'] ) )
			return $post_id;
		$nonce = $_POST['productoptions_nonce'];
		if ( !wp_verify_nonce( $nonce, 'productoptions_data' ) )
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
if (class_exists('productoptionsMetabox')) {
	new productoptionsMetabox;
};

class custombuttonMetabox {
	private $screen = array(
		'download',
	);
	private $meta_fields = array(
		array(
			'label' => 'Button Title',
			'id' => 'custom-button-title',
			'default' => '',
			'type' => 'text',
		),
		array(
			'label' => 'Button URL',
			'id' => 'custom-button-url',
			'default' => '',
			'type' => 'text',
		),
		array(
			'label' => 'Button Description',
			'id' => 'custom-button-description',
			'default' => '',
			'type' => 'text',
		),
	);
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'custombutton',
				__( 'Custom Button', 'mayosis' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'high'
			);
		}
	}
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'custombutton_data', 'custombutton_nonce' );
		$this->field_generator( $post );
	}
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
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
		echo '<div class="mayosis-meta-admin">' . $output . '</div>';
	}
	public function format_rows( $label, $input ) {
		return '<div class="mayosis-admin-col-12">'.$label.'<div class="mayosis-input-box-admin">'.$input.'</div></div>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['custombutton_nonce'] ) )
			return $post_id;
		$nonce = $_POST['custombutton_nonce'];
		if ( !wp_verify_nonce( $nonce, 'custombutton_data' ) )
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
if (class_exists('custombuttonMetabox')) {
	new custombuttonMetabox;
};