<?php
/**
 * This template is used to display the profile editor with [edd_profile_editor]
 */
global $current_user;

if ( is_user_logged_in() ):
	$user_id      = get_current_user_id();
	$first_name   = get_user_meta( $user_id, 'first_name', true );
	$last_name    = get_user_meta( $user_id, 'last_name', true );
	$display_name = $current_user->display_name;
	$address      = edd_get_customer_address( $user_id );
	$states       = edd_get_shop_states( $address['country'] );
	$state 		  = ( ! empty( $address['state'] ) ) ? $address['state'] : '';

	if ( edd_is_cart_saved() ): ?>
		<?php $restore_url = add_query_arg( array( 'edd_action' => 'restore_cart', 'edd_cart_token' => edd_get_cart_token() ), edd_get_checkout_uri() ); ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php esc_html_e( 'Saved cart','mayosis' ); ?>:</strong> <?php printf( __( 'You have a saved cart, <a href="%s">click here</a> to restore it.', 'mayosis' ), esc_url( $restore_url ) ); ?></div>
	<?php endif; ?>

	<?php if ( isset( $_GET['updated'] ) && $_GET['updated'] == true && ! edd_get_errors() ): ?>
		<div class="edd_success edd-alert edd-alert-success"><strong><?php esc_html_e( 'Success','mayosis' ); ?>:</strong> <?php esc_html_e( 'Your profile has been edited successfully.', 'mayosis' ); ?></div>
	<?php endif; ?>

	<?php edd_print_errors(); ?>

	<?php do_action( 'edd_profile_editor_before' ); ?>

	<form id="edd_profile_editor_form" class="edd_form" action="<?php echo edd_get_current_page_url(); ?>" method="post">

		<?php do_action( 'edd_profile_editor_fields_top' ); ?>

		<fieldset id="edd_profile_personal_fieldset">

			<legend id="edd_profile_name_label"><?php esc_html_e( 'Personal Information', 'mayosis' ); ?></legend>

			<div class="row">
				<div class="col-md-6">
					<label for="edd_first_name"><?php esc_html_e( 'First Name', 'mayosis' ); ?></label>
				<input name="edd_first_name" id="edd_first_name" class="text edd-input" type="text" value="<?php echo esc_attr( $first_name ); ?>" placeholder="Your First Name"/>
				</div>
				<div class="col-md-6">
					<label for="edd_last_name"><?php esc_html_e( 'Last Name', 'mayosis' ); ?></label>
				<input name="edd_last_name" id="edd_last_name" class="text edd-input" type="text" value="<?php echo esc_attr( $last_name ); ?>" placeholder="Your Last Name" />
				</div>
				
				<div class="col-md-6">
					<p id="edd_profile_display_name_wrap">
				<label for="edd_display_name"><?php esc_html_e( 'Display Name', 'mayosis' ); ?></label>
				<select name="edd_display_name" id="edd_display_name" class="select edd-select">
					<?php if ( ! empty( $current_user->first_name ) ): ?>
					<option <?php selected( $display_name, $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->first_name ); ?>"><?php echo esc_html( $current_user->first_name ); ?></option>
					<?php endif; ?>
					<option <?php selected( $display_name, $current_user->user_nicename ); ?> value="<?php echo esc_attr( $current_user->user_nicename ); ?>"><?php echo esc_html( $current_user->user_nicename ); ?></option>
					<?php if ( ! empty( $current_user->last_name ) ): ?>
					<option <?php selected( $display_name, $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->last_name ); ?>"><?php echo esc_html( $current_user->last_name ); ?></option>
					<?php endif; ?>
					<?php if ( ! empty( $current_user->first_name ) && ! empty( $current_user->last_name ) ): ?>
					<option <?php selected( $display_name, $current_user->first_name . ' ' . $current_user->last_name ); ?> value="<?php echo esc_attr( $current_user->first_name . ' ' . $current_user->last_name ); ?>"><?php echo esc_html( $current_user->first_name . ' ' . $current_user->last_name ); ?></option>
					<option <?php selected( $display_name, $current_user->last_name . ' ' . $current_user->first_name ); ?> value="<?php echo esc_attr( $current_user->last_name . ' ' . $current_user->first_name ); ?>"><?php echo esc_html( $current_user->last_name . ' ' . $current_user->first_name ); ?></option>
					<?php endif; ?>
				</select>
				<?php do_action( 'edd_profile_editor_name' ); ?>
			</p>
			<?php do_action( 'edd_profile_editor_after_name' ); ?>
				</div>
				<div class="col-md-6">
					<p>
				<label for="edd_email"><?php esc_html_e( 'Primary Email Address', 'mayosis' ); ?></label>
				<?php $customer = new EDD_Customer( $user_id, true ); ?>
				<?php if ( $customer->id > 0 ) : ?>

					<?php if ( 1 === count( $customer->emails ) ) : ?>
						<input name="edd_email" id="edd_email" class="text edd-input required" type="email" value="<?php echo esc_attr( $customer->email ); ?>"  placeholder="Your Email"/>
					<?php else: ?>
						<?php
							$emails           = array();
							$customer->emails = array_reverse( $customer->emails, true );

							foreach ( $customer->emails as $email ) {
								$emails[ $email ] = $email;
							}

							$email_select_args = array(
								'options'          => $emails,
								'name'             => 'edd_email',
								'id'               => 'edd_email',
								'selected'         => $customer->email,
								'show_option_none' => false,
								'show_option_all'  => false,
							);

							echo EDD()->html->select( $email_select_args );
						?>
					<?php endif; ?>
				<?php else: ?>
					<input name="edd_email" id="edd_email" class="text edd-input required" type="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" placeholder="Your Email"/>
				<?php endif; ?>

				<?php do_action( 'edd_profile_editor_email' ); ?>

			</p>
				</div>
				<div class="col-md-3">
					<?php if ( $customer->id > 0 && count( $customer->emails ) > 1 ) : ?>
			<div>
				<label for="edd_emails"><?php esc_html_e( 'Additional Email Addresses', 'mayosis' ); ?></label>
				<ul class="edd-profile-emails">
				<?php foreach ( $customer->emails as $email ) : ?>
					<?php if ( $email === $customer->email ) { continue; } ?>
					<li class="edd-profile-email">
						<?php echo esc_html($email); ?>
						<span class="actions">
							<?php
								$remove_url = wp_nonce_url(
									add_query_arg(
										array(
											'email'      => $email,
											'edd_action' => 'profile-remove-email',
											'redirect'   => esc_url( edd_get_current_page_url() ),
										)
									),
									'edd-remove-customer-email'
								);
							?>
							<a href="<?php echo esc_url($remove_url) ?>" class="delete"><?php esc_html_e( 'Remove', 'mayosis' ); ?></a>
						</span>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
				</div>
			</div>
			
			

			<?php do_action( 'edd_profile_editor_after_email' ); ?>

		</fieldset>

		<?php do_action( 'edd_profile_editor_after_personal_fields' ); ?>

		<fieldset id="edd_profile_address_fieldset">

			<legend id="edd_profile_billing_address_label"><?php esc_html_e( 'Billing Information', 'mayosis' ); ?></legend>

			<div class="row">
				<div class="col-md-12">
					<label for="edd_address_line1"><?php esc_html_e( 'Line 1', 'mayosis' ); ?></label>
				<input name="edd_address_line1" id="edd_address_line1" class="text edd-input" type="text" value="<?php echo esc_attr( $address['line1'] ); ?>" />
				</div>
				<div class="col-md-12">
					<label for="edd_address_line2"><?php esc_html_e( 'Line 2', 'mayosis' ); ?></label>
				<input name="edd_address_line2" id="edd_address_line2" class="text edd-input" type="text" value="<?php echo esc_attr( $address['line2'] ); ?>" />
					
				</div>
				<div class="col-md-6">
					<label for="edd_address_city"><?php esc_html_e( 'City', 'mayosis' ); ?></label>
				<input name="edd_address_city" id="edd_address_city" class="text edd-input" type="text" value="<?php echo esc_attr( $address['city'] ); ?>" />
					
				</div>
				<div class="col-md-6">
					
						<label for="edd_address_zip"><?php esc_html_e( 'Zip / Postal Code', 'mayosis' ); ?></label>
				<input name="edd_address_zip" id="edd_address_zip" class="text edd-input" type="text" value="<?php echo esc_attr( $address['zip'] ); ?>" />
				</div>
				<div class="col-md-6">
					<label for="edd_address_country"><?php esc_html_e( 'Country', 'mayosis' ); ?></label>
				<select name="edd_address_country" id="edd_address_country" class="select edd-select">
					<?php foreach( edd_get_country_list() as $key => $country ) : ?>
					<option value="<?php echo esc_html($key); ?>"<?php selected( $address['country'], $key ); ?>><?php echo esc_html( $country ); ?></option>
					<?php endforeach; ?>
				</select>
				</div>
				<div class="col-md-6">
					<label for="edd_address_state"><?php esc_html_e( 'State / Province', 'mayosis' ); ?></label>
				<?php
			        if( ! empty( $states ) ) : ?>
			        <select name="edd_address_state" id="edd_address_state" class="select edd-select">
		                <?php
		                    foreach( $states as $state_code => $state_name ) {
		                        echo '<option value="' . $state_code . '"' . selected( $state_code, $state, false ) . '>' . $state_name . '</option>';
		                    }
		                ?>
			        </select>
			       	<?php else : ?>
				<input name="edd_address_state" id="edd_address_state" class="text edd-input" type="text" value="<?php echo esc_attr( $state ); ?>" />
				<?php endif; ?>
				</div>
				<?php do_action( 'edd_profile_editor_address' ); ?>
			</div>
			<?php do_action( 'edd_profile_editor_after_address' ); ?>

		</fieldset>

		<?php do_action( 'edd_profile_editor_after_address_fields' ); ?>
			<legend id="edd_profile_billing_address_label"><?php esc_html_e( 'Password', 'mayosis' ); ?></legend>

		<div class="row">
				<div class="col-md-6">
					<label for="edd_user_pass"><?php esc_html_e( 'New Password', 'mayosis' ); ?></label>
				<input name="edd_new_user_pass1" id="edd_new_user_pass1" class="password edd-input" type="password"/>
					
				</div>
				<div class="col-md-6">
					
					<label for="edd_user_pass"><?php esc_html_e( 'Re-enter Password', 'mayosis' ); ?></label>
				<input name="edd_new_user_pass2" id="edd_new_user_pass2" class="password edd-input" type="password"/>
				</div>
				<?php do_action( 'edd_profile_editor_password' ); ?>
			</div>

		<?php do_action( 'edd_profile_editor_after_password_fields' ); ?>

		<fieldset id="edd_profile_submit_fieldset">

			<p id="edd_profile_submit_wrap">
				<input type="hidden" name="edd_profile_editor_nonce" value="<?php echo wp_create_nonce( 'edd-profile-editor-nonce' ); ?>"/>
				<input type="hidden" name="edd_action" value="edit_user_profile" />
				<input type="hidden" name="edd_redirect" value="<?php echo esc_url( edd_get_current_page_url() ); ?>" />
				<input name="edd_profile_editor_submit" id="edd_profile_editor_submit" type="submit" class="edd_submit edd-submit" value="<?php esc_html_e( 'Save Changes', 'mayosis' ); ?>"/>
			</p>

		</fieldset>

		<?php do_action( 'edd_profile_editor_fields_bottom' ); ?>

	</form><!-- #edd_profile_editor_form -->

	<?php do_action( 'edd_profile_editor_after' ); ?>

	<?php
else:
	echo '<p>' . __( 'You need to login to edit your profile.', 'mayosis' ) . '</p>';
	echo edd_login_form();
endif;