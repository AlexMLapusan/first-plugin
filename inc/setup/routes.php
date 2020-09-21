<?php

function al_register_routes() {
	register_rest_route( 'dash-adder/v1', 'test', array(
		'method'              => WP_REST_Server::EDITABLE,
		'callback'            => 'al_da_change_state',
		'permission_callback' => '__return_true',
	) );
}

function al_da_change_state() {
	update_option( 'dash-adder-state', $_POST['state'] );
	update_option( 'dash-adder-special-word', $_POST['special_word'] );

	return array( 'message' => 'state: ' . $_POST['state'] . ' special_word: ' . $_POST['special_word'] );
}
