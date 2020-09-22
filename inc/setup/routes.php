<?php

/**
 * Class post_modifier_Rest
 */
class Post_Modifier_Rest {
	public static $namespace = 'post_modifier/v1';
	public static $route     = '/save_settings';

	public function __construct() {
		$this->register_routes();
	}

	public function register_routes() {
		register_rest_route( static::$namespace, static::$route, array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( 'post_modifier_Rest', 'al_da_change_state' ),
			'permission_callback' => '__return_true',
		) );
	}

	/**
	 * @param WP_REST_Response $request
	 *
	 * @return string[] test message
	 */
	public static function al_da_change_state( $request ) {
		update_option( 'post-modifier-state', $request->get_param( 'plugin_state' ) );
		update_option( 'post-modifier-special-word', $request->get_param( 'special_word' ) );
		update_option( 'post-modifier-header-color', $request->get_param( 'header_color' ) );
		update_option( 'post-modifier-content-color', $request->get_param( 'content_color' ) );

		return array(
			'message' => 'state: ' . $request->get_param( 'plugin_state' ) . ' special_word: ' . $request->get_param( 'special_word' ) .
			             'header_color: ' . $request->get_param( 'header_color' ) . 'header_color: ' . $request->get_param( 'content_color' ),
		);
	}
}

new Post_Modifier_Rest();
