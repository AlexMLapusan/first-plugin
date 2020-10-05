<?php

/*
Plugin Name: Post modifier
Version: 1.0
*/

class Main {

	private function includes() {
		require_once 'inc/functions.php';
	}

	private function hooks() {

		add_action( 'rest_api_init', 'al_rest_api_init' );

		add_filter( 'the_title', 'al_add_dashes' );

		add_filter( 'get_the_time', 'al_format_date' );

		add_filter( 'the_date', 'al_format_date' );

		add_filter( 'post_class', 'al_add_post_class' );

		add_action( 'admin_menu', 'al_add_menu_item' );

		add_action( 'admin_enqueue_scripts', 'al_enqueue_scripts' );

		add_action( 'wp_enqueue_scripts', 'al_enqueue_scripts' );

		add_action( 'wp_head', 'al_alter_content_color' );

		add_shortcode( 'al_post_title', 'al_post_title' );

		add_filter('the_title', 'do_shortcode');
	}

	public function init() {
		$this->includes();
		$this->hooks();
	}
}

$main = new Main;
$main->init();
