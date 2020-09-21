<?php

/*
Plugin Name: Dashes adder
Version: 1.0
Description: Add two dashes to the title of a post.
*/

/**
 * todo: make a main class which calls an includes() function and a hooks function()
 * the idea is to init the main class from here, and then it includes the rest of the stuff
 */

//Includes
require_once 'inc/functions.php';

//This should be changed in a class maybe (??) - yes :D

//todo remove commented lines
//when WP calls "the_title", "al_add_dashes" is also called
//add_action( 'admin_init', 'al_register_dash_adder_settings' );

add_action( 'rest_api_init', 'ad_rest_api_init' );

/**
 * Register REST Routes
 */
function ad_rest_api_init() {
	require_once 'inc/setup/routes.php';
}

add_action( 'admin_init', 'al_register_dash_adder_options');

add_filter( 'the_title', 'al_add_dashes' );

add_action( 'admin_menu', 'al_add_menu_item' );

add_action( 'admin_enqueue_scripts', 'al_enqueue_scripts' );

add_action( 'wp_enqueue_scripts', 'al_enqueue_scripts' );
