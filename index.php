<?php

/*
 * Plugin Name: KGR Magic Password
 * Plugin URI: https://github.com/constracti/wp-magic-password
 * Description: Enables login as any user with a specific password.
 * Author: constracti
 * Version: 1.1.2
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: kgr
 * Domain Path: /languages
 */

if ( !defined( 'ABSPATH' ) )
	exit;

define( 'KGR_MAGIC_PASSWORD_DIR', plugin_dir_path( __FILE__ ) );
define( 'KGR_MAGIC_PASSWORD_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', function() {
	load_plugin_textdomain( 'kgr', FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );

require_once( KGR_MAGIC_PASSWORD_DIR . 'settings.php' );

add_filter( 'check_password', function( $check, $password, $hash, $user_id ): bool {
	$hash = get_option( 'kgr-magic-password', '' );
	if ( $hash === '' )
		return $check;
	if ( password_verify( $password, $hash ) )
		return TRUE;
	return $check;
}, 10, 4 );
