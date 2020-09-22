<?php

function al_enqueue_scripts() {
	wp_enqueue_script( 'al-main', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/main.js', array( 'wp-api' ), false, true );
	wp_localize_script( 'al-main', 'post_modifier', array(
		'settings' => array(
			'plugin_state'  => get_option( 'post-modifier-state' ),
			'special_word'  => get_option( 'post-modifier-special-word' ),
			'header_color'  => get_option( 'post-modifier-header-color' ),
			'content_color' => get_option( 'post-modifier-content-color' ),
		),
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

	if ( get_option( 'post-modifier-state' ) === 'on' ) {
		if ( in_the_loop() ) {
			if ( strpos( $title, get_option( 'post_modifier-special-word' ) ) !== false ) {
				$addition = '~--';
			} else {
				$addition = '--';
			}
			$title = $addition . $title . strrev( $addition );
			$title = '<span style=\'color:#' . get_option( 'post-modifier-header-color' ) . ';\'>' . $title . '</span>';
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

function al_register_post_modifier_options() {
	if ( ! get_option( 'post-modifier-state' ) ) {
		add_option( 'post-modifier-state', 'off' );
	}

	if ( ! get_option( 'post-modifier-special-word' ) ) {
		add_option( 'post-modifier-special-word', 'post' );
	}

	if ( ! get_option( 'post-modifier-header-color' ) ) {
		add_option( 'post-modifier-header-color', '000000' );
	}

	if ( ! get_option( 'post-modifier-content-color' ) ) {
		add_option( 'post-modifier-content-color', '000000' );
	}
}

function al_add_menu_item() {
	add_menu_page( 'Post modifier', 'Post modifier', 'administrator', 'al_da_settings', 'al_display_page', 'https://api.iconify.design/bi:dash-circle-fill.svg?color=%23FFF' );
}

function al_alter_content_color() {
	//todo use post_class to add an additional class to the head/body and set the color properly
	if ( get_option( 'post_modifier-state' ) === 'on' ) {
		echo '<style>
		.custom-header_color{
			color: #' . get_option( 'post-modifier-content-color' ) . ';
		}
		</style>';
	}
}

function al_add_post_class( $classes ) {
	$classes[] = 'custom-header_color';

	return $classes;
}


