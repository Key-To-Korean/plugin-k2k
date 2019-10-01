<?php
/**
 * CMB2 - Render Switch Button
 *
 * @package CMB2
 *
 * @link https://www.proy.info/how-to-create-cmb2-switch-field/
 */

/**
 *
 * Render custom Switch Button Field for CMB2.
 *
 * @param [type] $field The Field to be added.
 * @param [type] $escaped_value The value to be escaped.
 * @param [type] $object_id The ID of the object.
 * @param [type] $object_type The type of the object.
 * @param [type] $field_type_object The type of the field.
 */
function cmb2_render_switch( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

	$switch = '<div class="cmb2-switch">';

	$conditional_value = ( isset( $field->args['attributes']['data-conditional-value'] )
		? 'data-conditional-value="' . esc_attr( $field->args['attributes']['data-conditional-value'] ) . '"'
		: '' );

	$conditional_id = ( isset( $field->args['attributes']['data-conditional-id'] )
		? ' data-conditional-id="' . esc_attr( $field->args['attributes']['data-conditional-id'] ) . '"'
		: '' );

	$label_on = ( isset( $field->args['label'] )
		? esc_attr( $field->args['label']['on'] )
		: esc_attr__( 'On', 'k2k' ) );

	$label_off = ( isset( $field->args['label'] )
		? esc_attr( $field->args['label']['off'] )
		: esc_attr__( 'Off' ) );

	$switch .= '<input ' . $conditional_value . $conditional_id .
		' type="radio" id="' . $field->args['_id'] . '1" value="1"  ' .
		( 1 === $escaped_value ? 'checked="checked"' : '' ) .
		' name="' . esc_attr( $field->args['_name'] ) . '" />
		<input ' . $conditional_value . $conditional_id . ' type="radio" id="' .
		$field->args['_id'] . '2" value="0" ' .
		( ( '' === $escaped_value || 0 === $escaped_value ) ? 'checked="checked"' : '' ) .
		' name="' . esc_attr( $field->args['_name'] ) . '" />
		<label for="' . $field->args['_id'] . '1" class="cmb2-enable ' .
		( 1 === $escaped_value ? 'selected' : '' ) . '"><span>' . $label_on . '</span></label>
		<label for="' . $field->args['_id'] . '2" class="cmb2-disable ' .
		( ( '' === $escaped_value || 0 === $escaped_value ) ? 'selected' : '' ) . '"><span>' . $label_off . '</span></label>';

	$switch .= '</div>';
	$switch .= $field_type_object->_desc( true );

	echo wp_kses_post( $switch );

}
add_action( 'cmb2_render_switch', 'cmb2_render_switch', 10, 5 );

/**
 * Load related CSS and JS
 */
function cmb2_load_switch_scripts() {
	wp_enqueue_style( 'cmb2_switch-css', plugin_dir_url( __FILE__ ) . 'css/switch-button.css', false, '1.0.0' ); // CMB2 Switch Styling.
	wp_enqueue_script( 'cmb2_switch-js', plugin_dir_url( __FILE__ ) . 'js/switch-button.js', '', '1.0.0', true );  // CMB2 Switch Event.
}
add_action( 'admin_enqueue_scripts', 'cmb2_load_switch_scripts', 20 );
