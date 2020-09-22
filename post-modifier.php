<?php

/*
Plugin Name: Post modifier
Version: 1.0
*/

require_once 'inc/setup/settings.php';

$GLOBALS['settings'] = new PostModifierSettings();

class Main {

	private function includes() {
		require_once 'inc/functions.php';
	}

	private function hooks() {

		add_action( 'rest_api_init', 'al_rest_api_init' );

		add_filter( 'the_title', 'al_add_dashes' );

		add_filter( 'post_class', 'al_add_post_class');

		add_action( 'admin_menu', 'al_add_menu_item' );

		add_action( 'admin_enqueue_scripts', 'al_enqueue_scripts' );

		add_action( 'wp_enqueue_scripts', 'al_enqueue_scripts' );

		add_action( 'wp_head', 'al_alter_content_color' );
	}

	public function init() {
		$this->includes();
		$this->hooks();
	}
}

$main = new Main;
$main->init();
