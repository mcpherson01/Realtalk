<?php
/**
 * This template is used to display the registration form with [edd_register]
 */
global $edd_register_redirect;

do_action( 'edd_print_errors' ); ?>
	<div class="row main_login_form">
	<div class="login_form_dm">
	     <?php if (! is_user_logged_in() ) { ?>
<form id="edd_register_form" class="edd_form" action="" method="post">
	<?php do_action( 'edd_register_form_fields_top' ); ?>

	<fieldset>

		<?php do_action( 'edd_register_form_fields_before' ); ?>

		<p class="edd_registration_username">
			<input id="edd-user-login" class="required edd-input" type="text" name="edd_user_login" placeholder="Username"/>
		</p>

		<p class="edd_registration_email">
		
			<input id="edd-user-email" class="required edd-input" type="email" name="edd_user_email" placeholder="Email" />
		</p>

		<p class="edd_registration_password">
		
			<input id="edd-user-pass" class="password required edd-input" type="password" name="edd_user_pass" placeholder="Password" />
		</p>

		<p class="edd_registration_password">
			
			<input id="edd-user-pass2" class="password required edd-input" type="password" name="edd_user_pass2" placeholder="Confirm Password" />
		</p>


		<?php do_action( 'edd_register_form_fields_before_submit' ); ?>

		<p>
			<input type="hidden" name="edd_honeypot" value="" />
			<input type="hidden" name="edd_action" value="user_register" />
			<input type="hidden" name="edd_redirect" value="<?php echo esc_url( $edd_register_redirect ); ?>"/>
			<input class="button dm_register_button" name="edd_register_submit" type="submit" value="<?php esc_html_e( 'Register', 'mayosis' ); ?>" />
		</p>

		<?php do_action( 'edd_register_form_fields_after' ); ?>
	</fieldset>

	<?php do_action( 'edd_register_form_fields_bottom' ); ?>
</form>
		</div>
		<?php }else { ?>
		<p class="edd-logged-in">You are already logged in</p>
		<?php } ?>

</div>
