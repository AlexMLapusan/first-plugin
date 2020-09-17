<?php

/*
Plugin Name: Dashes adder
Version: 1.0
Description: Add two dashes to the title of a post.
*/

//Includes
require_once 'inc/functions.php';
require_once 'inc/setup/routes.php';

//This should be changed in a class maybe (??)

//when WP calls "the_title", "al_add_dashes" is also called
//add_action( 'admin_init', 'al_register_dash_adder_settings' );

add_action( 'admin_init', 'al_register_dash_adder_options');

add_filter( 'the_title', 'al_add_dashes' );

add_action( 'admin_menu', 'al_add_menu_item' );

add_action( 'admin_enqueue_scripts', 'al_enqueue_scripts' );

add_action( 'wp_enqueue_scripts', 'al_enqueue_scripts' );

add_action( 'rest_api_init', 'al_register_routes' );
