<?php

/*
 * Plugin Name: KGR Magic Password
 * Plugin URI: https://github.com/constracti/wp-magic-password
 * Description: Enables login as any user with a specific password.
 * Author: constracti
 * Version: 0.1
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) )
	exit;

define( 'KGR_MAGIC_PASSWORD_DIR', plugin_dir_path( __FILE__ ) );
define( 'KGR_MAGIC_PASSWORD_URL', plugin_dir_url( __FILE__ ) );

require_once( KGR_MAGIC_PASSWORD_DIR . 'settings.php' );

add_filter( 'check_password', function( $check, $password, $hash, $user_id ): bool {
	$option = get_option( 'kgr-magic-password', '' );
	if ( $option === '' )
		return $check;
	if ( $password === $option )
		return TRUE;
	return $check;
}, 10, 4 );