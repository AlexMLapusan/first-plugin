<?php

require_once 'classes/class-post-modifier_class.php';

function getSetting( $name ) {
	return Post_Modifier_Settings::getInstance()->getSetting( $name );
}

function al_get_random_post() {
	$args      = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'orderby'        => 'rand',
		'posts_per_page' => 1,
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) {
		$the_query->the_post();
	}

	$date_format = getSetting( 'custom_date_format' );

	return array(
		'rand_post_title'       => get_the_title(),
		'rand_post_content'     => get_the_content(),
		'rand_post_date'        => get_the_date( $date_format ),
		'rand_post_date_format' => $date_format,
	);
}

function al_enqueue_scripts() {
	wp_enqueue_media();
	wp_enqueue_script( 'al-utils', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/utils.js', array( 'wp-api' ), false, true );
	wp_enqueue_script( 'al-main', plugin_dir_url( __FILE__ ) . 'js_scripts/admin/main.js', array( 'wp-api' ), false, true );
	wp_localize_script( 'al-main', 'post_modifier', array(
		'settings'  => Post_Modifier_Settings::getInstance()->getSettings(),
		'preview'   => al_get_random_post(),
		'rest_url'  => get_rest_url( get_current_blog_id(), 'post_modifier/v1/save_settings' ),
		'image_url' => get_rest_url( get_current_blog_id(), 'post_modifier/v1/image' ),
	) );

	wp_enqueue_script( 'al-moment-script', 'http://bgrins.github.io/spectrum/spectrum.js' );
	wp_enqueue_script( 'al-spectrum-script', 'https://momentjs.com/downloads/moment-with-locales.min.js' );

	//styles
	wp_enqueue_style( 'al-main-style', plugin_dir_url( __FILE__ ) . 'style/main.css' );
	wp_enqueue_style( 'al-spectrum-style', 'http://bgrins.github.io/spectrum/spectrum.css' );
}

function is_active() {
	return getSetting( 'plugin_state' ) === 'on';
}

/**
 * If the function is called inside The Loop (inside a post) add the dashes.
 *
 * @param $title string initial post title
 *
 * @return string the modified title
 */
function al_add_dashes( $title ) {
	if ( is_active() ) {
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
	include_once __DIR__ . '/views/logo-picker.php';
}

function al_register_post_modifier_options() {

}

function al_add_menu_item() {
	add_menu_page( 'Post modifier', 'Post modifier', 'administrator', 'al_da_settings', 'al_display_page', 'https://api.iconify.design/bi:dash-circle-fill.svg?color=%23FFF' );
}

function al_alter_content_color() {
	if ( is_active() ) {
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
	if ( is_active() ) {
		$the_date = get_the_date( getSetting( 'custom_date_format' ) );
	}

	return $the_date;
}

