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

		register_rest_route( static::$namespace, '/image' . '/(?P<id>[\d]+)', array(
			array(
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => array( 'post_modifier_Rest', 'al_get_image' ),
				'permission_callback' => '__return_true',
			),
		) );
	}

	/**
	 * @param WP_REST_Response $request
	 */
	public static function al_get_image( $request ) {
		Post_Modifier_Settings::getInstance()->updateSetting( 'site_logo_src', wp_get_attachment_image_src( $request->get_param( 'id' ) )[0] );
		echo( json_encode( get_option( 'site_logo_src' ) ) );
	}

	/**
	 * @param WP_REST_Response $request
	 */
	public static function al_change_settings( $request ) {

		foreach ( $request->get_params() as $name => $value ) {
			Post_Modifier_Settings::getInstance()->updateSetting( $name, $value );
		}
	}
}

new Post_Modifier_Rest();
