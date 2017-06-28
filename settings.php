<?php

if ( !defined( 'ABSPATH' ) )
	exit;

add_filter( 'plugin_action_links_kgr-magic-password/kgr-magic-password.php', function( array $links ): array {
	$links[] = sprintf( '<a href="%s">%s</a>', menu_page_url( 'kgr-magic-password', FALSE ), esc_html__( 'Settings' ) );
	return $links;
} );

add_action( 'admin_menu', function() {
	if ( !current_user_can( 'administrator' ) )
		return;
	$page_title = esc_html__( 'KGR Magic Password', 'kgr' );
	$menu_title = esc_html__( 'KGR Magic Password', 'kgr' );
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
		sprintf( '<label for="%s">%s</label>', esc_attr( $name ), esc_html__( 'Magic Password', 'kgr' ) ),
		function( array $args ) {
			$name = $args['name'];
			echo sprintf( '<input type="password" name="%s" id="%s" class="regular-text" autocomplete="off" />', esc_attr( $name ), esc_attr( $name ) ) . "\n";
			echo sprintf( '<p class="description">%s</p>', esc_html__( 'Set a really strong password. Leave empty to disable login using a magic password.', 'kgr' ) ) . "\n";
		},
		$group,
		$section,
		[
			'name' => $name,
		]
	);
} );

function kgr_magic_password_settings_notice( string $class, string $dashicon, string $message ) {
?>
<div class="notice notice-<?= $class ?>">
	<p class="dashicons-before dashicons-<?= $dashicon ?>"><?= $message ?></p>
</div>
<?php
}

function kgr_magic_password_settings() {
	if ( !current_user_can( 'administrator' ) )
		return;
	echo '<div class="wrap">' . "\n";
	echo sprintf( '<h1>%s</h1>', esc_html__( 'KGR Magic Password', 'kgr' ) ) . "\n";
	$hash = get_option( 'kgr-magic-password', '' );
	if ( $hash === '' )
		kgr_magic_password_settings_notice( 'info', 'info', esc_html__( 'No magic password is set.', 'kgr' ) );
	else
		kgr_magic_password_settings_notice( 'warning', 'warning', esc_html__( 'Login using a magic password is enabled.', 'kgr' ) );
	echo '<form method="post" action="options.php">' . "\n";
	settings_fields( 'kgr-magic-password' );
	do_settings_sections( 'kgr-magic-password' );
	submit_button();
	echo '</form>' . "\n";
	echo '</div>' . "\n";
}

add_filter( 'pre_update_option_kgr-magic-password', function( string $value ): string {
	if ( $value === '' )
		return $value;
	return password_hash( $value, PASSWORD_DEFAULT );
} );
