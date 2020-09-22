<?php

class PostModifierSettings {
	private $settings = [];

	/**
	 * PostModifierSettings constructor.
	 *
	 * @param array $settings
	 */
	public function __construct(  ) {
		$this->settings = array(
			'plugin_state'  => get_option( 'plugin_state', 'off' ),
			'special_word'  => get_option( 'special_word', 'post' ),
			'header_color'  => get_option( 'header_color', '000000' ),
			'content_color' => get_option( 'content_color', '000000' ),
		);
	}

	/**
	 * @return array
	 */
	public function getSettings() {
		return $this->settings;
	}

	/**
	 * @param $settingName string
	 *
	 * @return string
	 */
	public function getSetting( $settingName ) {
		return $this->settings[ $settingName ];
	}

	/**
	 * @param array $settings
	 */
	public function setSettings( $settings ) {
		$this->settings = $settings;
	}

	public function updateSetting( $name, $value ) {
		$settings[$name] = $value;
		update_option( $name, $value );
	}


}