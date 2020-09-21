<?php


function al_enqueue_scripts() {
	wp_enqueue_script( 'al-main', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/main.js', array( 'wp-api' ), false, true );
	wp_localize_script( 'al-main', 'dash_adder', array(
		'settings' => array(
			'plugin_state' => get_option( 'dash-adder-state' ),
			'special_word' => get_option( 'dash-adder-special-word' ),
		),
		'rest_url' => get_rest_url( get_current_blog_id(), 'dash-adder/v1/save_settings' ),
	) );

	//styles
	wp_enqueue_style( 'al-main-style', plugin_dir_url( __FILE__ ) . 'style/main.css' );
}


/**
 * If the function is called inside The Loop (inside a post) add the dashes.
 *
 * @param $title string initial post title
 *
 * @return string the modified title
 */
function al_add_dashes( $title ) {

	if ( get_option( 'dash-adder-state' ) === 'on' ) {
		if ( in_the_loop() ) {
			if ( strpos( $title, get_option( 'dash-adder-special-word' ) ) !== false ) {
				$addition = '~--';
			} else {
				$addition = '--';
			}
			$title = $addition . $title . strrev( $addition );
		}
	}

	return $title;
}

/**
 * Register REST Routes
 */
function al_rest_api_init() {
	require_once __DIR__ . '/setup/routes.php';
}

function al_display_page() {

	include_once __DIR__ . '/views/admin.php';
}

function al_register_dash_adder_options() {
	if ( ! get_option( 'dash-adder-state' ) ) {
		add_option( 'dash-adder-state', 'off' );
	}

	if ( ! get_option( 'dash-adder-special-word' ) ) {
		add_option( 'dash-adder-special-word', 'post' );
	}
}

function al_add_menu_item() {
	add_menu_page( 'Dash adder', 'Dash adder', 'administrator', 'al-da-settings', 'al_display_page', 'https://api.iconify.design/bi:dash-circle-fill.svg?color=%23FFF' );
}


