<?php

require_once 'classes/class-post-modifier_class.php';

function getSetting( $name ) {
	$settings = Post_Modifier_Settings::getInstance();
	return $settings->getSetting( $name );
}

function al_enqueue_scripts() {
	$settings = Post_Modifier_Settings::getInstance();

	wp_enqueue_script( 'al-utils', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/utils.js', array( 'wp-api' ), false, true );
	wp_enqueue_script( 'al-main', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/main.js', array( 'wp-api' ), false, true );
	wp_localize_script( 'al-main', 'post_modifier', array(
		'settings' => $settings->getSettings(),
		'rest_url' => get_rest_url( get_current_blog_id(), 'post_modifier/v1/save_settings' ),
	) );

	wp_enqueue_script( 'al-spectrum-script', 'http://bgrins.github.io/spectrum/spectrum.js' );

	//styles
	wp_enqueue_style( 'al-main-style', plugin_dir_url( __FILE__ ) . 'style/main.css' );
	wp_enqueue_style( 'al-spectrum-style', 'http://bgrins.github.io/spectrum/spectrum.css' );
}


/**
 * If the function is called inside The Loop (inside a post) add the dashes.
 *
 * @param $title string initial post title
 *
 * @return string the modified title
 */
function al_add_dashes( $title ) {

	if ( getSetting('plugin_state') === 'on' ) {
		if ( in_the_loop() ) {
			if ( strpos( $title, getSetting( 'special_word' ) ) !== false ) {
				$addition = '~--';
			} else {
				$addition = '--';
			}
			$title = $addition . $title . strrev( $addition );
			$title = '<span style=\'color:#' . get_option( 'header_color' ) . ';\'>' . $title . '</span>';
		}
	}

	return $title;
}

/**
 * Register REST Routes
 */
function al_rest_api_init() {
	require_once __DIR__ . '/setup/class-post-modifier-rest.php';
}

function al_display_page() {

	include_once __DIR__ . '/views/main.php';
	include_once __DIR__ . '/views/post-content.php';
	include_once __DIR__ . '/views/post-metadata.php';
	include_once __DIR__ . '/views/live-preview.php';
}

function al_register_post_modifier_options() {

}

function al_add_menu_item() {
	add_menu_page( 'Post modifier', 'Post modifier', 'administrator', 'al_da_settings', 'al_display_page', 'https://api.iconify.design/bi:dash-circle-fill.svg?color=%23FFF' );
}

function al_alter_content_color() {
	if ( getSetting( 'plugin_state' ) === 'on' ) {
		echo '<style>
		.custom-header_color{
			color: #' . get_option( 'content_color' ) . ';
		}
		</style>';
	}
}

function al_add_post_class( $classes ) {
	$classes[] = 'custom-header_color';

	return $classes;
}

function al_format_date( $the_date ) {
	if ( getSetting( 'plugin_state' ) === 'on' ) {
		$the_date = get_the_date( getSetting( 'custom_date_format' ) );
	}

	return $the_date;
}

