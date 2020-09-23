<?php

class Constants {

	public static function settings_names() {
		return array(
			'plugin_state',
			'special_word',
			'header_color',
			'content_color',
			'custom_date_format',
		);
	}

	public static function settings_defaults() {
		return array(
			'plugin_state'  => 'off',
			'special_word'  => 'post',
			'header_color'  => '000000',
			'content_color' => '000000',
			'custom_date_format' => 'D, M, Y',
		);
	}
}