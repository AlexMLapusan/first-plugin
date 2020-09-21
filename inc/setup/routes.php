<?php

/**
 * Class Dash_Adder_Rest
 */
class Dash_Adder_Rest {
	public static $namespace = 'dash-adder/v1';
	public static $route     = '/save_settings';

	public function __construct() {
		$this->register_routes();
	}

	public function register_routes() {
		register_rest_route( static::$namespace, static::$route, array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( 'Dash_Adder_Rest', 'al_da_change_state' ),
			'permission_callback' => '__return_true',
		) );
	}

	/**
	 * @param WP_REST_Response $request
	 *
	 * @return string[] test message
	 */
	public static function al_da_change_state( $request ) {
		update_option( 'dash-adder-state', $request->get_param( 'plugin_state' ) );
		update_option( 'dash-adder-special-word', $request->get_param( 'special_word' ) );

		return array( 'message' => 'state: ' . $request->get_param( 'plugin_state' ) . ' special_word: ' . $request->get_param( 'special_word' ) );
	}
}

new Dash_Adder_Rest();
