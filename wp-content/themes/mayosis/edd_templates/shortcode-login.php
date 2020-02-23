<?php
/**
 * This template is used to display the login form with [edd_login]
 */
global $edd_login_redirect;
if ( ! is_user_logged_in() ) :

	// Show any error messages after form submission
	edd_print_errors(); ?>
	<div class="row main_login_form">
	<div class="login_form_dm">
	<form id="edd_login_form" class="edd_form" action="" method="post">
		<fieldset>
			<?php do_action( 'edd_login_fields_before' ); ?>
			<p class="edd-login-username">
				
				<input name="edd_user_login" id="edd_user_login" class="edd-required edd-input" type="text" placeholder="Your Username or Email"/>
			</p>
			<p class="edd-login-password">
				
				<input name="edd_user_pass" id="edd_user_pass" class="edd-password edd-required edd-input" type="password" placeholder="Your Password"/>
			</p>
			<p class="edd-login-remember">
				<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span> <?php esc_html_e( 'Remember Me', 'mayosis' ); ?></span></label>
			</p>
			<p class="edd-lost-password">
				<a href="<?php echo wp_lostpassword_url(); ?>">
					<?php esc_html_e( 'Lost Password?', 'mayosis' ); ?>
				</a>
			</p>
			<p class="edd-login-submit">
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_login_redirect ); ?>"/>
				<input type="hidden" name="edd_login_nonce" value="<?php echo wp_create_nonce( 'edd-login-nonce' ); ?>"/>
				<input type="hidden" name="edd_action" value="user_login"/>
				<input id="edd_login_submit" type="submit" class="edd_submit edd-submit" value="<?php esc_html_e( 'Login', 'mayosis' ); ?>"/>
			</p>
			
			<?php do_action( 'edd_login_fields_after' ); ?>
		</fieldset>
	</form>
		</div>
	
	</div>
<?php else : ?>
	<p class="edd-logged-in"><?php esc_html_e( 'You are already logged in', 'mayosis' ); ?></p>
<?php endif; ?>