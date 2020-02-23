<?php

function marketixins_widget() {
	register_widget( 'null_instagram_widget' );
}
add_action( 'widgets_init', 'marketixins_widget' );

Class null_instagram_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'null-instagram-feed',
			__( 'Mayosis Instagram', 'marketix' ),
			array(
				'classname' => 'null-instagram-feed',
				'description' => esc_html__( 'Displays your latest Instagram photos', 'marketix' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	function widget( $args, $instance ) {

		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$username = empty( $instance['username'] ) ? '' : $instance['username'];
		$limit = empty( $instance['number'] ) ? 9 : $instance['number'];
		$size = empty( $instance['size'] ) ? 'large' : $instance['size'];
		$target = empty( $instance['target'] ) ? '_self' : $instance['target'];
		$link = empty( $instance['link'] ) ? '' : $instance['link'];

		echo $args['before_widget'];

		if ( ! empty( $title ) ) { echo $args['before_title'] . wp_kses_post( $title ) . $args['after_title']; };

		do_action( 'marketixins_before_widget', $instance );

		if ( '' !== $username ) {

			$media_array = $this->scrape_instagram( $username );

			if ( is_wp_error( $media_array ) ) {

				echo wp_kses_post( $media_array->get_error_message() );

			} else {

				// filter for images only?
				if ( $images_only = apply_filters( 'marketixins_images_only', false ) ) {
					$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
				}

				// slice list down to required limit.
				$media_array = array_slice( $media_array, 0, $limit );

				// filters for custom classes.
				$ulclass = apply_filters( 'marketixins_list_class', 'marketix-instagram-pics instagram-size-' . $size );
				$liclass = apply_filters( 'marketixins_item_class', '' );
				$aclass = apply_filters( 'marketixins_a_class', '' );
				$imgclass = apply_filters( 'marketixins_img_class', '' );
				$template_part = apply_filters( 'marketixins_template_part', 'parts/marketix.php' );

				?><ul class="<?php echo esc_attr( $ulclass ); ?>"><?php
				foreach( $media_array as $item ) {
					// copy the else line into a new file (parts/marketix.php) within your theme and customise accordingly.
					if ( locate_template( $template_part ) !== '' ) {
						include locate_template( $template_part );
					} else {
						echo '<li class="' . esc_attr( $liclass ) . '"><a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $target ) . '"  class="' . esc_attr( $aclass ) . '"><img src="' . esc_url( $item[$size] ) . '"  alt="' . esc_attr( $item['description'] ) . '" title="' . esc_attr( $item['description'] ) . '"  class="' . esc_attr( $imgclass ) . '"/></a></li>';
					}
				}
				?></ul><?php
			}
		}

		$linkclass = apply_filters( 'marketixins_link_class', 'clear' );
		$linkaclass = apply_filters( 'marketixins_linka_class', '' );

		switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url = '//instagram.com/explore/tags/' . str_replace( '#', '', $username );
				break;

			default:
				$url = '//instagram.com/' . str_replace( '@', '', $username );
				break;
		}

		if ( '' !== $link ) {
			?><p class="<?php echo esc_attr( $linkclass ); ?>"><a href="<?php echo trailingslashit( esc_url( $url ) ); ?>" rel="me" target="<?php echo esc_attr( $target ); ?>" class="<?php echo esc_attr( $linkaclass ); ?>"><?php echo wp_kses_post( $link ); ?></a></p><?php
		}

		do_action( 'marketixins_after_widget', $instance );

		echo $args['after_widget'];
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => __( 'Instagram', 'marketix' ),
			'username' => '',
			'size' => 'small',
			'link' => __( 'Follow Me!', 'marketix' ),
			'number' => 9,
			'target' => '_self',
		) );
		$title = $instance['title'];
		$username = $instance['username'];
		$number = absint( $instance['number'] );
		$size = $instance['size'];
		$target = $instance['target'];
		$link = $instance['link'];
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'marketix' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( '@username or #tag', 'marketix' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos', 'marketix' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" /></label></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Photo size', 'marketix' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
				<option value="thumbnail" <?php selected( 'thumbnail', $size ); ?>><?php esc_html_e( 'Thumbnail', 'marketix' ); ?></option>
				<option value="small" <?php selected( 'small', $size ); ?>><?php esc_html_e( 'Small', 'marketix' ); ?></option>
				<option value="large" <?php selected( 'large', $size ); ?>><?php esc_html_e( 'Large', 'marketix' ); ?></option>
			
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open links in', 'marketix' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
				<option value="_self" <?php selected( '_self', $target ); ?>><?php esc_html_e( 'Current window (_self)', 'marketix' ); ?></option>
				<option value="_blank" <?php selected( '_blank', $target ); ?>><?php esc_html_e( 'New window (_blank)', 'marketix' ); ?></option>
			</select>
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>"><?php esc_html_e( 'Link text', 'marketix' ); ?>: <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'link' ) ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></label></p>
		<?php

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = trim( strip_tags( $new_instance['username'] ) );
		$instance['number'] = ! absint( $new_instance['number'] ) ? 9 : $new_instance['number'];
		$instance['size'] = ( ( 'thumbnail' === $new_instance['size'] || 'large' === $new_instance['size'] || 'small' === $new_instance['size'] || 'original' === $new_instance['size'] ) ? $new_instance['size'] : 'large' );
		$instance['target'] = ( ( '_self' === $new_instance['target'] || '_blank' === $new_instance['target'] ) ? $new_instance['target'] : '_self' );
		$instance['link'] = strip_tags( $new_instance['link'] );
		return $instance;
	}

	// based on https://gist.github.com/cosmocatalano/4544576.
	function scrape_instagram( $username ) {

		$username = trim( strtolower( $username ) );

		if ( false === ( $instagram = get_transient( 'instagram-a9-' . sanitize_title_with_dashes( $username ) ) ) ) {

			switch ( substr( $username, 0, 1 ) ) {
				case '#':
					$url = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
					break;

				default:
					$url = 'https://instagram.com/' . str_replace( '@', '', $username );
					break;
			}

			$remote = wp_remote_get( $url );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'marketix' ) );
			}

			if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'marketix' ) );
			}

			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'marketix' ) );
			}

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
			} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'marketix' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'marketix' ) );
			}

			$instagram = array();

			foreach ( $images as $image ) {
				// Note: keep hashtag support different until these JSON changes stabalise
				// these are mostly the same again now
				switch ( substr( $username, 0, 1 ) ) {
					case '#':
						if ( true === $image['node']['is_video'] ) {
							$type = 'video';
						} else {
							$type = 'image';
						}

						$caption = __( 'Instagram Image', 'marketix' );
						if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
							$caption = $image['node']['edge_media_to_caption']['edges'][0]['node']['text'];
						}

						$instagram[] = array(
							'description'   => $caption,
							'link'		  	=> trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
							'time'		  	=> $image['node']['taken_at_timestamp'],
							'comments'	  	=> $image['node']['edge_media_to_comment']['count'],
							'likes'		 	=> $image['node']['edge_liked_by']['count'],
							'thumbnail'	 	=> preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
							'small'			=> preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
							'large'			=> preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
							'original'		=> preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
							'type'		  	=> $type,
						);
						break;
					default:
						if ( true === $image['is_video'] ) {
							$type = 'video';
						} else {
							$type = 'image';
						}

						$caption = __( 'Instagram Image', 'marketix' );
						if ( ! empty( $image['caption'] ) ) {
							$caption = $image['caption'];
						}

						$instagram[] = array(
							'description'   => $caption,
							'link'		  	=> trailingslashit( '//instagram.com/p/' . $image['code'] ),
							'time'		  	=> $image['date'],
							'comments'	  	=> $image['comments']['count'],
							'likes'		 	=> $image['likes']['count'],
							'thumbnail'	 	=> preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][0]['src'] ),
							'small'			=> preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][2]['src'] ),
							'large'			=> preg_replace( '/^https?\:/i', '', $image['thumbnail_resources'][4]['src'] ),
							'original'		=> preg_replace( '/^https?\:/i', '', $image['display_src'] ),
							'type'		  	=> $type,
						);

						break;
				}
			} // End foreach().

			// do not set an empty transient - should help catch private or empty accounts.
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-a9-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		if ( ! empty( $instagram ) ) {

			return unserialize( base64_decode( $instagram ) );

		} else {

			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.(May be its a Private Profile, Disable Private Option)', 'marketix' ) );

		}
	}

	function images_only( $media_item ) {

		if ( 'image' === $media_item['type'] ) {
			return true;
		}

		return false;
	}
}
