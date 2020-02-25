<?php

class MTS_Updater {

  // this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
  const MTS_API_URL = 'https://wordpress.metatags.io';

  // you should use your own CONSTANT name, and be sure to replace it throughout this file
  const MTS_API_ITEM_NAME = 'Meta Tags WP Plugin';

  // slug for the license page
  const MTS_API_PLUGIN_LICENSE_PAGE = 'meta-tags-license';


  function __construct() {
    add_action('admin_menu', array($this,'mts_license_menu'));
    add_action('admin_init', array($this,'mts_register_option'));
    add_action('admin_init', array($this,'mts_activate_license'));
    add_action('admin_init', array($this,'mts_deactivate_license'));
    add_action('admin_notices', array($this,'mts_admin_notices'));
  }


  // Admin license menu
  function mts_license_menu() {
    add_plugins_page( 'Plugin License', 'Meta Tags License', 'manage_options', self::MTS_API_PLUGIN_LICENSE_PAGE, array($this,'mts_license_page'));
  }

  // Admin license template
  function mts_license_page() {
    $license = get_option( 'mts_license_key' );
    $status  = get_option( 'mts_license_status' );
    ?>
    <div class="wrap">
      <h2><?php _e('Plugin License Options'); ?></h2>
      <h3><?php echo self::MTS_API_ITEM_NAME ?></h3>
      <form method="post" action="options.php">

        <?php settings_fields('mts_license'); ?>

        <table class="form-table">
          <tbody>
            <tr valign="top">
              <th scope="row" valign="top">
                <?php _e('License Key'); ?>
              </th>
              <td>
                <input id="mts_license_key" name="mts_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
                <label class="description" for="mts_license_key"><?php _e('Enter your license key'); ?></label>
              </td>
            </tr>
            <?php if( false !== $license ) { ?>
              <tr valign="top">
                <th scope="row" valign="top">
                  <?php _e('Activate License'); ?>
                </th>
                <td>
                  <?php if( $status !== false && $status == 'valid' ) { ?>
                    <span style="color:green;"><?php _e('active'); ?></span>
                    <?php wp_nonce_field( 'mts_nonce', 'mts_nonce' ); ?>
                    <input type="submit" class="button-secondary" name="mts_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
                  <?php } else {
                    wp_nonce_field( 'mts_nonce', 'mts_nonce' ); ?>
                    <input type="submit" class="button-secondary" name="mts_license_activate" value="<?php _e('Activate License'); ?>"/>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <?php submit_button(); ?>

      </form>
    <?php
  }


  function mts_register_option() {
    // creates our settings in the options table
    register_setting('mts_license', 'mts_license_key', array($this,'mts_sanitize_license') );
  }


  function mts_sanitize_license( $new ) {
    $old = get_option( 'mts_license_key' );
    if( $old && $old != $new ) {
      delete_option( 'mts_license_status' ); // new license has been entered, so must reactivate
    }
    return $new;
  }



  /************************************
  * this illustrates how to activate
  * a license key
  *************************************/

  function mts_activate_license() {

    // listen for our activate button to be clicked
    if( isset( $_POST['mts_license_activate'] ) ) {

      // run a quick security check
      if( ! check_admin_referer( 'mts_nonce', 'mts_nonce' ) )
        return; // get out if we didn't click the Activate button

      // retrieve the license from the database
      $license = trim( get_option( 'mts_license_key' ) );


      // data to send in our API request
      $api_params = array(
        'edd_action' => 'activate_license',
        'license'    => $license,
        'item_name'  => urlencode( self::MTS_API_ITEM_NAME ), // the name of our product in EDD
        'url'        => home_url()
      );

      // Call the custom API.
      $response = wp_remote_post( self::MTS_API_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

      // make sure the response came back okay
      if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

        if ( is_wp_error( $response ) ) {
          $message = $response->get_error_message();
        } else {
          $message = __( 'An error occurred, please try again.' );
        }

      } else {

        $license_data = json_decode( wp_remote_retrieve_body( $response ) );

        if ( false === $license_data->success ) {

          switch( $license_data->error ) {

            case 'expired' :

              $message = sprintf(
                __( 'Your license key expired on %s.' ),
                date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
              );
              break;

            case 'disabled' :
            case 'revoked' :

              $message = __( 'Your license key has been disabled.' );
              break;

            case 'missing' :

              $message = __( 'Invalid license.' );
              break;

            case 'invalid' :
            case 'site_inactive' :

              $message = __( 'Your license is not active for this URL.' );
              break;

            case 'item_name_mismatch' :

              $message = sprintf( __( 'This appears to be an invalid license key for %s.' ), self::MTS_API_ITEM_NAME );
              break;

            case 'no_activations_left':

              $message = __( 'Your license key has reached its activation limit.' );
              break;

            default :

              $message = __( 'An error occurred, please try again.' );
              break;
          }

        }

      }

      // Check if anything passed on a message constituting a failure
      if ( ! empty( $message ) ) {
        $base_url = admin_url( 'plugins.php?page=' . self::MTS_API_PLUGIN_LICENSE_PAGE );
        $redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

        wp_redirect( $redirect );
        exit();
      }

      // $license_data->license will be either "valid" or "invalid"

      update_option( 'mts_license_status', $license_data->license );
      wp_redirect( admin_url( 'plugins.php?page=' . self::MTS_API_PLUGIN_LICENSE_PAGE ) );
      exit();
    }
  }



  /***********************************************
  * Illustrates how to deactivate a license key.
  * This will decrease the site count
  ***********************************************/

  function mts_deactivate_license() {

    // listen for our activate button to be clicked
    if( isset( $_POST['mts_license_deactivate'] ) ) {

      // run a quick security check
      if( ! check_admin_referer( 'mts_nonce', 'mts_nonce' ) )
        return; // get out if we didn't click the Activate button

      // retrieve the license from the database
      $license = trim( get_option( 'mts_license_key' ) );


      // data to send in our API request
      $api_params = array(
        'edd_action' => 'deactivate_license',
        'license'    => $license,
        'item_name'  => urlencode( self::MTS_API_ITEM_NAME ), // the name of our product in EDD
        'url'        => home_url()
      );

      // Call the custom API.
      $response = wp_remote_post( self::MTS_API_URL, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

      // make sure the response came back okay
      if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

        if ( is_wp_error( $response ) ) {
          $message = $response->get_error_message();
        } else {
          $message = __( 'An error occurred, please try again.' );
        }

        $base_url = admin_url( 'plugins.php?page=' . self::MTS_API_PLUGIN_LICENSE_PAGE );
        $redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

        wp_redirect( $redirect );
        exit();
      }

      // decode the license data
      $license_data = json_decode( wp_remote_retrieve_body( $response ) );

      // $license_data->license will be either "deactivated" or "failed"
      if( $license_data->license == 'deactivated' ) {
        delete_option( 'mts_license_status' );
      }

      wp_redirect( admin_url( 'plugins.php?page=' . self::MTS_API_PLUGIN_LICENSE_PAGE ) );
      exit();

    }
  }



  /**
   * This is a means of catching errors from the activation method above and displaying it to the customer
   */
  function mts_admin_notices() {
    if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) {

      switch( $_GET['sl_activation'] ) {

        case 'false':
          $message = urldecode( $_GET['message'] );
          ?>
          <div class="error">
            <p><?php echo $message; ?></p>
          </div>
          <?php
          break;

        case 'true':
        default:
          // Developers can put a custom success message here for when activation is successful if they way.
          break;

      }
    }
  }





}

$mts_updater = new MTS_Updater();

?>
