<?php

require_once __DIR__ . '/../setup/trait-settings.php';

class Post_Modifier_Settings {
	private $settings = [];

	use Settings;

	/**
	 * @param $settingName string
	 *
	 * @return string
	 */
	public function getSetting( $settingName ) {
		return $this->settings[ $settingName ];
	}

	public function getSettings() {
		return $this->settings;
	}

	/**
	 * @param array $settings
	 */
	public function setSettings( $settings ) {
		$this->settings = $settings;
	}

	public function updateSetting( $name, $value ) {
		$settings[ $name ] = $value;
		update_option( $name, $value );
	}
}




