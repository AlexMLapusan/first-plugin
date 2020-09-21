<?php

/*
Plugin Name: Dashes adder
Version: 1.0
*/

class Main {

	private function includes() {
		require_once 'inc/functions.php';
	}

	private function hooks() {

		add_action( 'rest_api_init', 'al_rest_api_init' );

		add_action( 'admin_init', 'al_register_dash_adder_options' );

		add_filter( 'the_title', 'al_add_dashes' );

		add_action( 'admin_menu', 'al_add_menu_item' );

		add_action( 'admin_enqueue_scripts', 'al_enqueue_scripts' );

		add_action( 'wp_enqueue_scripts', 'al_enqueue_scripts' );

	}

	public function init() {
		$this->includes();
		$this->hooks();
	}
}

$main = new Main;
$main->init();
