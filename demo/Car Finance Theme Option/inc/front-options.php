<?php
// create custom plugin settings menu
add_action('admin_menu', 'my_test_plugin_create_menu');
function my_test_plugin_create_menu() {
    //create new top-level menu
    add_menu_page('Theme Options', 'Theme Options', 'manage_options','car_finance', 'my_test_plugin_settings_page','dashicons-screenoptions');

    add_submenu_page('car_finance','Quote List', 'Quote List', 'manage_options','quote_list', 'quote_list_callback');
    //call register settings function
    add_action( 'admin_init', 'register_my_test_plugin_settings' );}
function register_my_test_plugin_settings() {
    //register our settings
    register_setting( 'my-test-plugin-settings-group', 'finance_rate' );
    register_setting( 'my-test-plugin-settings-group', 'bad_rate' );
    register_setting( 'my-test-plugin-settings-group', 'bad_pname' );
    register_setting( 'my-test-plugin-settings-group', 'good_rate' );
    register_setting( 'my-test-plugin-settings-group', 'fair_rate' );
    register_setting( 'my-test-plugin-settings-group', 'us_partners_desc' );
    register_setting( 'my-test-plugin-settings-group', 'us_press_release' );
    register_setting( 'my-test-plugin-settings-group', 'amount_min' );
    register_setting( 'my-test-plugin-settings-group', 'amount_max' );
    register_setting( 'my-test-plugin-settings-group', 'min_year' );
    register_setting( 'my-test-plugin-settings-group', 'max_year' );
    register_setting( 'my-test-plugin-settings-group', 'amount_step' );
    register_setting( 'my-test-plugin-settings-group', 'default_amount' );
    register_setting( 'my-test-plugin-settings-group', 'year_step' );
    register_setting( 'my-test-plugin-settings-group', 'default_year' );
}
function my_test_plugin_settings_page() {
?>
<div class="wrap">
    <h1><strong>Auto Finance Theme Option</strong></h1>
    <form method="post" action="options.php" class="theme-options">
        <?php settings_fields( 'my-test-plugin-settings-group' ); ?>
        <?php do_settings_sections( 'my-test-plugin-settings-group' ); ?>
        <table class="form-table">
            <h2><strong>Auto Finance Calculator Option</strong></h2>
            <tr valign="top">
            <th>Car Finance Excellent Interest rate</th>
            <td><input type="text" name="finance_rate"  value="<?php echo esc_attr(get_option("finance_rate")); ?>">
            </td>
            </tr>
            <tr>
            <th>Car Finance Good Interest rate</th>
            <td><input type="text" name="good_rate"  value="<?php echo esc_attr(get_option("good_rate")); ?>">
            </td>
            </tr>
            <tr>
            <th>Car Finance Fair Interest rate</th>
            <td><input type="text" name="fair_rate"  value="<?php echo esc_attr(get_option("fair_rate")); ?>">
            </td>
            </tr>
            <tr>
            <th>Car Finance Bad Interest rate</th>
            <td><input type="text" name="bad_rate"  value="<?php echo esc_attr(get_option("bad_rate")); ?>">
            </td>
            </tr>
            <tr>
            <th>Bad Credit Car Finance page name</th>
            <td><input type="text" name="bad_pname"  value="<?php echo esc_attr(get_option("bad_pname")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance amount set minimum range</th>
            <td><input type="number" name="amount_min"  value="<?php echo esc_attr(get_option("amount_min")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance amount set maximum range</th>
            <td><input type="number" name="amount_max"  value="<?php echo esc_attr(get_option("amount_max")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance set minimum range for year</th>
            <td><input type="number" name="min_year"  value="<?php echo esc_attr(get_option("min_year")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance set maximum range for year</th>
            <td><input type="number" name="max_year"  value="<?php echo esc_attr(get_option("max_year")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance amount step</th>
            <td><input type="number" name="amount_step"  value="<?php echo esc_attr(get_option("amount_step")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance default amount</th>
            <td><input type="number" name="default_amount"  value="<?php echo esc_attr(get_option("default_amount")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance year step</th>
            <td><input type="number" name="year_step"  value="<?php echo esc_attr(get_option("year_step")); ?>">
            </td>
            </tr>
            <tr valign="top">
            <th>Car Finance default year</th>
            <td><input type="number" name="default_year"  value="<?php echo esc_attr(get_option("default_year")); ?>">
            </td>
            </tr>
        </table>
        <table class="form-table">
           <tr valign="top">
            <th>Car-Finance Description</th>
            <td>
            <?php
            $us_partners_desc = get_option( 'us_partners_desc' );
            wp_editor( $us_partners_desc, 'editor_id', array('media_buttons' => false,
            'textarea_rows' => 6,
            'tabindex' => 4,
            'textarea_name' => 'us_partners_desc',
            'teeny'         => true, 
            'menubar'     => true,
            'editor_class'  => 'block-editor',
            'quicktags' => true)  );
            ?>
            </td>
            </tr>
            <tr valign="top">
            <th>Press Detail Bottom Note</th>
            <td>
            <?php
            $us_press_release = get_option( 'us_press_release' );
            wp_editor( $us_press_release, 'editor_id2', array('media_buttons' => false,
            'textarea_rows' => 6,
            'tabindex' => 4,
            'textarea_name' => 'us_press_release',
            'teeny'         => true, 
            'menubar'     => true,
            'editor_class'  => 'block-editor',
            'quicktags' => true)  );
            ?>
            </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
<?php 
}
?>