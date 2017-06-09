<?php

if ( !defined( 'ABSPATH' ) )
	exit;

add_filter( 'plugin_action_links_kgr-magic-password/kgr-magic-password.php', function( array $links ): array {
	$links[] = sprintf( '<a href="%s">%s</a>', menu_page_url( 'kgr-magic-password', FALSE ), 'Settings' );
	return $links;
} );

add_action( 'admin_menu', function() {
	if ( !current_user_can( 'administrator' ) )
		return;
	$page_title = 'KGR Magic Password';
	$menu_title = 'KGR Magic Password';
	$menu_slug = 'kgr-magic-password';
	$function = 'kgr_magic_password_settings';
	add_submenu_page( 'options-general.php', $page_title, $menu_title, 'administrator', $menu_slug, $function );
} );

add_action( 'admin_init', function() {
	if ( !current_user_can( 'administrator' ) )
		return;
	$group = 'kgr-magic-password';
	$section = 'kgr-magic-password';
	add_settings_section( $section, '', '__return_null', $group );
	$name = 'kgr-magic-password';
	register_setting( $group, $name );
	add_settings_field(
		$name,
		sprintf( '<label for="%s">%s</label>', esc_attr( $name ), esc_html( 'Password' ) ),
		function( array $args ) {
			$name = $args['name'];
			$value = get_option( $name, '' );
			echo sprintf( '<input type="password" name="%s" id="%s" class="regular-text" autocomplete="off" value="%s" />',
				esc_attr( $name ),
				esc_attr( $name ),
				esc_attr( $value )
			) . "\n";
		},
		$group,
		$section,
		[
			'name' => $name,
		]
	);
} );

function kgr_magic_password_settings() {
	if ( !current_user_can( 'administrator' ) )
		return;
	echo '<div class="wrap">' . "\n";
	echo sprintf( '<h1>%s</h1>', 'KGR Magic Password' ) . "\n";
	echo '<form method="post" action="options.php">' . "\n";
	settings_fields( 'kgr-social-login' );
	do_settings_sections( 'kgr-social-login' );
	submit_button();
	echo '</form>' . "\n";
	echo '</div>' . "\n";
}
