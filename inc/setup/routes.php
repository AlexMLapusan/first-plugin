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
			'callback'            => array( 'post_modifier_Rest', 'al_change_settings' ),
			'permission_callback' => '__return_true',
		) );
	}

	/**
	 * @param WP_REST_Response $request
	 *
	 * @return string[] test message
	 */
	public static function al_change_settings( $request ) {

		foreach ( $request->get_params() as $name => $value ) {
			$GLOBALS['settings']->updateSetting($name, $value);
		}

		return array(
			'message' => 'state: ' . $GLOBALS['settings']->getSetting( 'plugin_state' ) . ' special_word: ' . $GLOBALS['settings']->getSetting( 'special_word' ) .
			             'header_color: ' . $GLOBALS['settings']->getSetting( 'header_color' ) . 'content_color: ' . $GLOBALS['settings']->getSetting( 'content_color' ),
		);
	}
}

new Post_Modifier_Rest();
