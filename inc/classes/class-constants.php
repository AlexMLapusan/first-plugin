<?php

class Constants {

	public static function settings_defaults() {
		return array(
			'plugin_state'       => 'off',
			'special_word'       => 'post',
			'header_color'       => '000000',
			'content_color'      => '000000',
			'custom_date_format' => 'D, M, Y',
			'logo_srcs'          => array(
				array(
					'id'  => 'desktop',
					'src' => '',
				),
				array(
					'id'  => 'tablet',
					'src' => '',
				),
				array(
					'id'  => 'mobile',
					'src' => '',
				),
			),
		);
	}

	public static function devices(){
		return array('desktop' => 992,
		             'tablet' => 768,
		             'mobile' => 480);
	}

}