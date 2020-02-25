<?php

/**
 * Assets manager Premium base class
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, GitHub: https://github.com/alexkovalevv
 * @copyright (c) 01.10.2018, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WGNZP_Check_Conditions {

	/**
	 * Get current URL
	 *
	 * @return string
	 */
	protected function get_current_url_path() {
		if ( ! is_admin() ) {
			$url = explode( '?', $_SERVER['REQUEST_URI'], 2 );
			if ( strlen( $url[0] ) > 1 ) {
				$out = rtrim( $url[0], '/' );
			} else {
				$out = $url[0];
			}

			return "/" === $out ? "/" : untrailingslashit( $out );
		}

		$removeble_args = array_merge( [ 'wbcr_assets_manager' ], wp_removable_query_args() );

		$url = remove_query_arg( $removeble_args, $_SERVER['REQUEST_URI'] );

		return untrailingslashit( $url );
	}

	/**
	 * Check by operator
	 *
	 * @param $operator
	 * @param $first
	 * @param $second
	 * @param $third
	 *
	 * @return bool
	 */
	public function apply_operator( $operator, $first, $second, $third = false ) {
		switch ( $operator ) {
			case 'equals':
				return $first === $second;
			case 'notequal':
				return $first !== $second;
			case 'less':
			case 'older':
				return $first > $second;
			case 'greater':
			case 'younger':
				return $first < $second;
			case 'contains':
				return strpos( $first, $second ) !== false;
			case 'notcontain':
				return strpos( $first, $second ) === false;
			case 'between':
				return $first < $second && $second < $third;

			default:
				return $first === $second;
		}
	}

	/**
	 * Determines whether the user's browser has a cookie with a given name
	 *
	 * @param $operator
	 * @param $value
	 *
	 * @return boolean
	 */
	public function user_cookie_name( $operator, $value ) {
		if ( isset( $_COOKIE[ $value ] ) ) {
			return $operator === 'equals';
		} else {
			return $operator === 'notequal';
		}
	}

	/**
	 * Проверяет пользовательское регулярное выражение
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  2.0.0
	 *
	 * @param string $operator
	 * @param string $value
	 */
	public function regular_expression( $operator, $value ) {
		$current_url_path = $this->get_current_url_path();

		$check_url = ltrim( $current_url_path, '/\\' );
		$regexp    = trim( str_replace( '\\\\', '\\', $value ), '/' );

		return @preg_match( "/{$regexp}/", $check_url );
	}

	/**
	 * Проверяет проивольный url с маской
	 *
	 * @param $operator
	 * @param $value
	 *
	 * @return boolean
	 */
	public function location_page( $operator, $value ) {
		$first_url_path  = str_replace( site_url(), '', $value );
		$second_url_path = $this->get_current_url_path();

		if ( ! strpos( $first_url_path, '*' ) ) {
			return $this->apply_operator( $operator, $second_url_path, $first_url_path );
		}

		// Получаем строку до *
		$first_url_path = strstr( $first_url_path, '*', true );
		// Если это был не пустой url (типа http://site/*) и есть вхождение с начала
		if ( untrailingslashit( $first_url_path ) && strpos( untrailingslashit( $second_url_path ), $first_url_path ) === 0 ) {
			return true;
		}

		return false;
	}

	/**
	 * A role of the user who views your website. The role "guest" is applied for unregistered users.
	 *
	 * @param string $operator
	 * @param string $value
	 *
	 * @return boolean
	 */
	public function user_role( $operator, $value ) {
		if ( ! function_exists( 'is_user_logged_in' ) ) {
			if ( @count( @preg_grep( '/^wordpress_logged_in/', @array_keys( $_COOKIE ) ) ) > 0 ) {
				if ( isset( $_COOKIE['wam_assigned_roles'] ) && is_array( $_COOKIE['wam_assigned_roles'] ) ) {
					$assigned_roles = $_COOKIE['wam_assigned_roles'];
				} else {
					$assigned_roles = [];
				}

				if ( in_array( $value, $assigned_roles ) ) {
					return true;
				}
			}

			return false;
		}

		if ( ! is_user_logged_in() ) {
			return $this->apply_operator( $operator, $value, 'guest' );
		} else {
			$current_user = wp_get_current_user();
			if ( ! ( $current_user instanceof WP_User ) ) {
				return false;
			}

			return $this->apply_operator( $operator, $value, $current_user->roles[0] );
		}
	}

	/**
	 * Check the user views your website from mobile device or not
	 *
	 * @param string $operator
	 * @param string $value
	 *
	 * @return boolean
	 *
	 * @link https://stackoverflow.com/a/4117597
	 */
	public function user_mobile( $operator, $value ) {
		$useragent = $_SERVER['HTTP_USER_AGENT'];

		if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) ) {
			return $operator === 'equals' && $value === 'yes' || $operator === 'notequal' && $value === 'no';
		} else {
			return $operator === 'notequal' && $value === 'yes' || $operator === 'equals' && $value === 'no';
		}
	}
}