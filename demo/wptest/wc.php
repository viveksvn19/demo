<?php
/**
 * Display field value on the order received  page
 */
function pickup_display_order_data( $order_id ){  ?>
    <h2><?php _e( 'Pickup Information' ); ?></h2>
    <table class="shop_table shop_table_responsive additional_info">
        <tbody>
            <tr>
                <th><?php _e( 'Pickup Location:' ); ?></th>
                <td><?php echo get_post_meta( $order_id, 'pickuplocationmethod', true ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Pickup Date:' ); ?></th>
                <td><?php echo get_post_meta( $order_id, 'pickupdatemethod', true ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Payment By:' ); ?></th>
                <td><?php echo get_post_meta( $order_id, 'paypart', true ); ?></td>
            </tr>
        </tbody>
    </table>
<?php }
/**
 * Display field value on the email 
*/
function pickup_show_email_order_meta( $order, $sent_to_admin, $plain_text ) {
    $pickuplocationmethod = get_post_meta( $order->id, 'pickuplocationmethod', true );
    $pickupdatemethod = get_post_meta( $order->id, 'pickupdatemethod', true );
    $paypart = get_post_meta( $order->id, 'paypart', true );
    if( $plain_text ){
        $data = '<p><strong>Pickup Location is:</strong> ' . $pickuplocationmethod. ' <strong> Pickup Date is:</strong> ' . $pickupdatemethod . '</p>';
		$data .= '<p><strong>Payment By:</strong> ' . $paypart. '</p>';
		print $data;

    } else {
        $data = '<p><strong>Pickup Location is:</strong> ' . $pickuplocationmethod. ' <strong> Pickup Date is:</strong> ' . $pickupdatemethod . '</p>';
        $data .= '<p><strong>Payment By:</strong> ' . $paypart. '</p>';
        print $data;
	}
}
add_action('woocommerce_email_customer_details', 'pickup_show_email_order_meta', 30, 3 );
// Remove 'Billing' word from the error message 
add_action( 'woocommerce_thankyou', 'pickup_display_order_data', 20 );
add_action( 'woocommerce_view_order', 'pickup_display_order_data', 20 );
function customize_wc_errors( $error ) {
    if ( strpos( $error, 'Billing ' ) !== false ) {
        $error = str_replace("Billing ", "", $error);
    }
    return $error;
}
add_filter( 'woocommerce_add_error', 'customize_wc_errors' );
// Remove fields in checkout page and Address in Account pages //
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_postcode']);
  //unset($fields['billing']['billing_email']);
  return $fields;
}
// Removes Order Notes Title – Additional Information & Notes Field
add_filter( 'woocommerce_enable_order_notes_field', '__return_false', 9999 );
// Remove Order Notes Field
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );
function remove_order_notes( $fields ) {
    unset($fields['order']['order_comments']);
    return $fields;
}
// Woocommerce add advance field //
//Change the Billing Details checkout label to Your Details
function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Billing details' :
            $translated_text = __( 'Pickup Information', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );
add_action('wp_head','custom_css');
function custom_css(){
    echo '<style>.woocommerce-cart pre,.woocommerce-checkout pre,.woocommerce-order-received pre{white-space: normal;}.woocommerce-checkout .col-1{width:75% !important;} ul.products .edgtf-pl-category{display:none;} ul.products>.product .edgtf-product-list-title {font-size: 18px;}</style>';
}
// To hide price on product and inner pages 
add_filter( 'woocommerce_get_price_html', 'chesapeakepie_hide_product_price' );
function chesapeakepie_hide_product_price( $price ) {
    return '';
}
// To hide in stock
function chesapeakepie_hide_in_stock_message( $html, $text, $product ) {
    $availability = $product->get_availability();
    if ( isset( $availability['class'] ) && 'in-stock' === $availability['class'] ) {
        return '';
    }
    return $html;
}
add_filter( 'woocommerce_stock_html', 'chesapeakepie_hide_in_stock_message', 10, 3 );
// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'chesapeakepie_single_add_to_cart_text' ); 
function chesapeakepie_single_add_to_cart_text() {
    return __( 'Preorder Pie', 'woocommerce' ); 
}
// To change add to cart text on product pages
add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
function replacing_add_to_cart_button( $button, $product  ) {
    $button_text = __("Learn More", "woocommerce");
    $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';

    return $button;
}
?>