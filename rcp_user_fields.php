<?php
/*
Plugin Name: Restrict Content Pro - Custom User Fields
Description: Custom user fields for community assocations.
Version: 1.0
Author: Clever IT
Author URI: https://cleverit.ca
*/


/**
 * Adds the custom fields to the registration form and profile editor
 *
 */
function pw_rcp_add_user_fields() {

	$address = get_user_meta( get_current_user_id(), 'rcp_address', true );
	$phonenumber   = get_user_meta( get_current_user_id(), 'rcp_phonenumber', true );
    $children = get_user_meta( get_current_user_id(), 'rcp_children', true );
    $residents = get_user_meta( get_current_user_id(), 'rcp_residents', true );
    $volunteer = get_user_meta( get_current_user_id(), 'rcp_volunteer', true );


	?>
	<table>
    <thead>
        <tr>
            <th><label for="rcp_address"><?php _e( 'Your Address (Required)', 'rcp' ); ?></label></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><input name="rcp_address" placeholder="Home Address" id="rcp_address" type="text" value="<?php echo esc_attr( $address ); ?>" required/></td>
        </tr>
    </tbody>
</table>
	<p>Optional Information</p>
	<table>
    <thead>
        <tr>
            <th><label for="rcp_phonenumber"><?php _e( 'Your Phone Number', 'rcp' ); ?></label></th>
            <th><label for="rcp_children"><?php _e( 'Number of Children in Household', 'rcp' ); ?></label></th>
            <th><label for="rcp_residents"><?php _e( 'Number of People in Household', 'rcp' ); ?></label></th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td><input name="rcp_phonenumber" placeholder="Phone Number" id="rcp_phonenumber" type="text" value="<?php echo esc_attr( $phonenumber ); ?>"/></td>
            <td><input type="number" id="rcp_children" name="rcp_children" placeholder="Number of Children" value="<?php echo esc_attr( $children ); ?>"/></td>
            <td><input type="number" id="rcp_residents" name="rcp_residents" placeholder="Number of Residents" value="<?php echo esc_attr( $residents ); ?>"/></td>
        </tr>
    </tbody>
</table>
    <p>
        <label for="rcp_volunteer"><?php _e( 'I would like to volunteer with the community association.', 'rcp' ); ?></label>
        <select id="rcp_volunteer" name="rcp_volunteer">
            <option value="yes" <?php selected( $volunteer, 'yes'); ?>><?php _e( 'Yes', 'rcp' ); ?></option>
            <option value="no" <?php selected( $volunteer, 'no'); ?>><?php _e( 'No', 'rcp' ); ?></option>
        </select>
    </p>
	<?php
}
add_action( 'rcp_before_subscription_form_fields', 'pw_rcp_add_user_fields' );
add_action( 'rcp_profile_editor_after', 'pw_rcp_add_user_fields' );

/**
 * Adds the custom fields to the member edit screen
 *
 */
function pw_rcp_add_member_edit_fields( $user_id = 0 ) {

	$address = get_user_meta( $user_id, 'rcp_address', true );
	$phonenumber   = get_user_meta( $user_id, 'rcp_phonenumber', true );
	$children   = get_user_meta( $user_id, 'rcp_children', true );
	$residents   = get_user_meta( $user_id, 'rcp_residents', true );
	$volunteer   = get_user_meta( $user_id, 'rcp_volunteer', true );

	?>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_address"><?php _e( 'Address', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_address" id="rcp_address" type="text" value="<?php echo esc_attr( $address ); ?>"/>
			<p class="description"><?php _e( 'The member\'s address', 'rcp' ); ?></p>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row" valign="top">
			<label for="rcp_address"><?php _e( 'Phone Number', 'rcp' ); ?></label>
		</th>
		<td>
			<input name="rcp_phonenumber" id="rcp_phonenumber" type="text" value="<?php echo esc_attr( $phonenumber ); ?>"/>
			<p class="description"><?php _e( 'The member\'s phone number', 'rcp' ); ?></p>
		</td>
	</tr>
    <tr valign="top">
        <th scope="row" valign="top">
            <label for="rcp_children"><?php _e( 'Children', 'rcp' ); ?></label>
        </th>
        <td>
            <input type="number" id="rcp_children" name="rcp_children" value="<?php echo esc_attr( $children ); ?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" valign="top">
            <label for="rcp_residents"><?php _e( 'Residents', 'rcp' ); ?></label>
        </th>
        <td>
            <input type="number" id="rcp_residents" name="rcp_residents" value="<?php echo esc_attr( $residents ); ?>"/>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" valign="top">
            <label for="rcp_volunteer"><?php _e( 'I would like to volunteer with the community association.', 'rcp' ); ?></label>
        </th>
        <td>
            <select id="rcp_volunteer" name="rcp_volunteer">
                <option value="yes" <?php selected( $volunteer, 'yes'); ?>><?php _e( 'Yes', 'rcp' ); ?></option>
                <option value="no" <?php selected( $volunteer, 'no'); ?>><?php _e( 'No', 'rcp' ); ?></option>
            </select>
        </td>
    </tr>
	<?php
}
add_action( 'rcp_edit_member_after', 'pw_rcp_add_member_edit_fields' );

/**
 * Determines if there are problems with the registration data submitted
 *
 */
function pw_rcp_validate_user_fields_on_register( $posted ) {

	if( empty( $posted['rcp_address'] ) ) {
		rcp_errors()->add( 'invalid_address', __( 'Please enter your address', 'rcp' ), 'register' );
	}

}
add_action( 'rcp_form_errors', 'pw_rcp_validate_user_fields_on_register', 10 );

/**
 * Stores the information submitted during registration
 *
 */
function pw_rcp_save_user_fields_on_register( $posted, $user_id ) {

	if( ! empty( $posted['rcp_address'] ) ) {
		update_user_meta( $user_id, 'rcp_address', sanitize_text_field( $posted['rcp_address'] ) );
	}
	if( ! empty( $_POST['rcp_phonenumber'] ) ) {
		update_user_meta( $user_id, 'rcp_phonenumber', sanitize_text_field( $_POST['rcp_phonenumber'] ) );
	}
    if ( ! empty( $_POST['rcp_children'] ) ) {
        update_user_meta( $user_id, 'rcp_children', absint( $_POST['rcp_children'] ) );
    }
    if ( ! empty( $_POST['rcp_residents'] ) ) {
        update_user_meta( $user_id, 'rcp_residents', absint( $_POST['rcp_residents'] ) );
    }
    if ( ! empty( $posted['rcp_volunteer'] ) ) {
        update_user_meta( $user_id, 'rcp_volunteer', sanitize_text_field( $posted['rcp_volunteer'] ) );
    }
}
add_action( 'rcp_form_processing', 'pw_rcp_save_user_fields_on_register', 10, 2 );

/**
 * Stores the information submitted profile update
 *
 */
function pw_rcp_save_user_fields_on_profile_save( $user_id ) {

	if( ! empty( $_POST['rcp_address'] ) ) {
		update_user_meta( $user_id, 'rcp_address', sanitize_text_field( $_POST['rcp_address'] ) );
	}
    if( ! empty( $_POST['rcp_phonenumber'] ) ) {
		update_user_meta( $user_id, 'rcp_phonenumber', sanitize_text_field( $_POST['rcp_phonenumber'] ) );
	}
    if ( ! empty( $_POST['rcp_children'] ) ) {
        update_user_meta( $user_id, 'rcp_children', absint( $_POST['rcp_children'] ) );
    }
    if ( ! empty( $_POST['rcp_residents'] ) ) {
        update_user_meta( $user_id, 'rcp_residents', absint( $_POST['rcp_residents'] ) );
    }
    // List all the available options that can be selected.
    $available_choices = array(
        'yes',
        'no'
    );
    if ( isset( $_POST['rcp_volunteer'] ) && in_array( $_POST['rcp_volunteer'], $available_choices ) ) {
        update_user_meta( $user_id, 'rcp_volunteer', sanitize_text_field( $_POST['rcp_volunteer'] ) );
    }


}
add_action( 'rcp_user_profile_updated', 'pw_rcp_save_user_fields_on_profile_save', 10 );
add_action( 'rcp_edit_member', 'pw_rcp_save_user_fields_on_profile_save', 10 );

/**
 * Import custom user fields
 *
 * @param int    $user_id         ID number of the user being imported.
 * @param array  $user_data       Array of user data, including first name, last name, and email.
 * @param int    $subscription_id ID number of the subscription this user is being added to.
 * @param string $status          Status this user is being set to.
 * @param string $expiration      User's new expiration date in MySQL format.
 * @param array  $row             Array of all data in this user's row.
 */
function ag_rcp_import_custom_fields( $user_id, $user_data, $subscription_id, $status, $expiration, $row ) {

    $address = $row['rcp_address'];

    if ( ! empty( $address ) ) {
        // Change 'address' to the user meta key you'd like to save the data as.
        update_user_meta( $user_id, 'rcp_address', sanitize_text_field( $address ) );
    }

    $phonenumber = $row['rcp_phonenumber'];

    if ( ! empty( $phonenumber ) ) {
        update_user_meta( $user_id, 'rcp_phonenumber', sanitize_text_field( $phonenumber ) );
    }

    $children = $row['rcp_children'];

    if ( ! empty( $children ) ) {
        update_user_meta( $user_id, 'rcp_children', sanitize_text_field( $children ) );
    }

    $residents = $row['rcp_residents'];

    if ( ! empty( $residents ) ) {
        update_user_meta( $user_id, 'rcp_residents', sanitize_text_field( $residents ) );
    }

    $volunteer = $row['rcp_volunteer'];

    if ( ! empty( $volunteer ) ) {
        update_user_meta( $user_id, 'rcp_volunteer', sanitize_text_field( $volunteer ) );
    }

}

/**
 * Register a custom menu page.
 */
function rcp_register_settings_page() {
    add_menu_page(
        __( 'RCP User fields', 'textdomain' ),
        'custom menu',
        'manage_options',
        'rcp-user-fields/settingn-admin.php',
        '',
        plugins_url( 'rcp-user-fields/images/icon.png' ),
    );
}
add_action( 'admin_menu', 'rcp_register_settings_page');


add_action( 'rcp_user_import_user_added', 'ag_rcp_import_custom_fields', 10, 6 );
