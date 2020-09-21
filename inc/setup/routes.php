<?php

function al_register_routes() {
	register_rest_route( 'dash-adder/v1', 'test', array(
		'method'              => WP_REST_Server::EDITABLE,
		'callback'            => 'al_da_change_state',
		'permission_callback' => '__return_true',
	) );
}

/**
 * @param WP_REST_Response $request
 *
 * @return string[] test message
 */
function al_da_change_state( $request ) {
	update_option( 'dash-adder-state', $request->get_param( 'state' ) );
	update_option( 'dash-adder-special-word', $request->get_param('special_word') );

	return array( 'message' => 'state: ' . $request->get_param('state') . ' special_word: ' . $request->get_param('special_word') );
}
