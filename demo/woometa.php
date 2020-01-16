<?php
// add meta field 
//* Add select field to the checkout page
add_action('woocommerce_after_order_notes', 'wps_add_select_checkout_field',1);
function wps_add_select_checkout_field( $checkout ) {
    //echo '<h2>'.__('Payment options').'</h2>';
    woocommerce_form_field( 'paypart', array(
        'type'          => 'radio',
        'required'  => true,
        'class'         => array( 'input-text' ),
        'label'         => __( 'Payment options' ),
        'options'       => array(
            "Invoice me via paypal"   => __( "Invoice me via paypal", "wps" ),
            "I'll pay on pickup" => __( "I'll pay on pickup", "wps" ),
        )
 ),
    $checkout->get_value( 'paypart' ));
}
add_action( 'woocommerce_after_checkout_billing_form', 'chesapeak_location_field' );
add_action( 'woocommerce_after_checkout_billing_form', 'chesapeak_date_field' );
// save fields to order meta
add_action( 'woocommerce_checkout_update_order_meta', 'chesapeak_save_what_we_added' );
// pickup location
function chesapeak_location_field( $checkout ){
    woocommerce_form_field( 'pickuplocationmethod', array(
    'type'          => 'textarea', // text, textarea, select, radio, checkbox, password, about custom validation a little later
    'required'  => true, // actually this parameter just adds "*" to the field
    'class'         => array('input-text ', 'form-row-wide'), // array only, read more about classes and styling in the previous step
    'label'         => 'Pickup location',
    'label_class'   => 'billing_location', // sometimes you need to customize labels, both string and
    ), $checkout->get_value( 'pickuplocationmethod' ) );
}
// pickup date
function chesapeak_date_field( $checkout ){
    woocommerce_form_field( 'pickupdatemethod', array(
        'type'          => 'text', // text, textarea, select, radio, checkbox, password, about custom validation a little later
        'required'  => true, // actually this parameter just adds "*" to the field
        'class'         => array('chdatetime'), // array only, read more about classes and styling in the previous step
        'label'         => 'Pickup date',
        'label_class'   => 'billing_date', // sometimes you need to customize labels, both string and
        
    ), $checkout->get_value( 'pickupdatemethod' ) );
}
//* Process the checkout on error setup
add_action('woocommerce_checkout_process', 'wps_select_checkout_field_process');
function wps_select_checkout_field_process() {
    global $woocommerce;
    // Check if set, if its not set add an error.
    if (empty($_POST['paypart']) or $_POST['paypart'] == ""){
     wc_add_notice( '<strong>Payment options</strong> is a required field.', 'error' );
    }
    if (empty($_POST['pickuplocationmethod']) or $_POST['pickuplocationmethod'] == ""){
     wc_add_notice( '<strong>Pickup location </strong> is a required field.', 'error' );
    }
    if (empty($_POST['pickupdatemethod']) or $_POST['pickupdatemethod'] == ""){
     wc_add_notice( '<strong>Pickup date</strong> is a required field.', 'error' );
    }
}
// save field values
function chesapeak_save_what_we_added( $order_id ){
    if( !empty( $_POST['pickuplocationmethod'] ) )
        update_post_meta( $order_id, 'pickuplocationmethod', sanitize_text_field( $_POST['pickuplocationmethod'] ) );
    if( !empty( $_POST['pickupdatemethod'] ) )
        update_post_meta( $order_id, 'pickupdatemethod', sanitize_text_field( $_POST['pickupdatemethod']    ) ); 
    if( !empty( $_POST['paypart'] ) )
        update_post_meta( $order_id, 'paypart', sanitize_text_field( $_POST['paypart']    ) ); 
}
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Pickup Location').':</strong> <br/>' . get_post_meta( $order->get_id(), 'pickuplocationmethod', true ) . '</p>';
    echo '<p><strong>'.__('Pickup Date').':</strong> <br/>' . get_post_meta( $order->get_id(), 'pickupdatemethod', true ) . '</p>';
    echo '<p><strong>'.__('Payment option').':</strong> <br/>' . get_post_meta( $order->get_id(), 'paypart', true ) . '</p>';
}
?>