<?php
/*
Plugin Name: Plygnd WP Redirect After Login
Description: Redirects users to a specific page after they login
Version: 0.5
Author: Anthony Raudino
Author URI: https://github.com/anthonyraudino/plygnd-wp-redirect-after-login/
*/

function custom_login_redirect( $redirect_to, $request, $user ) {
    $redirect_url = get_option( 'redirect_url' );
    if ( !empty( $redirect_url ) ) {
        return $redirect_url;
    } else {
        return home_url( '/wp-admin/' );
    }
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );

function add_redirect_menu_item() {
    add_options_page( 'Redirect After Login Settings', 'Redirect After Login', 'manage_options', 'redirect-after-login-settings', 'redirect_settings_page', 'dashicons-admin-generic' );
}
add_action( 'admin_menu', 'add_redirect_menu_item' );

function redirect_settings_page() {
    ?>
    <div class="wrap">
        <h1>Redirect After Login Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'redirect_after_login_options' ); ?>
            <?php do_settings_sections( 'redirect-after-login-settings' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">New Redirect URL (Replacing the Current Redirect URL)</th>
                    <td><input type="text" name="redirect_url" value="<?php echo esc_attr( get_option( 'redirect_url' ) ); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function redirect_settings_init() {
    register_setting( 'redirect_after_login_options', 'redirect_url' );
    add_settings_section( 'redirect_after_login_section', 'Redirect After Login Settings', 'redirect_section_callback', 'redirect-after-login-settings' );
    add_settings_field( 'redirect_url', 'Redirect URL', 'redirect_url_callback', 'redirect-after-login-settings', 'redirect_after_login_section' );
}
add_action( 'admin_init', 'redirect_settings_init' );

function redirect_section_callback() {
    echo '<p>Enter the URL you would like users to be redirected to after logging in.</p>';
}

function redirect_url_callback() {
    echo '<input type="text" name="redirect_url" value="' . esc_attr( get_option( 'redirect_url' ) ) . '" />';
}

?>