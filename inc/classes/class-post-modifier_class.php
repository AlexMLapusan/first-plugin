<?php

require_once __DIR__ . '/../setup/trait-settings.php';
require_once __DIR__ . '/class-constants.php';

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
		$this->settings[ $name ] = $value;
		update_option( $name, $value );
	}

	public function updateLogoSrcs( $device, $value ) {
		$this->settings['logo_srcs'][array_search($device, array_column($this->settings['logo_srcs'], 'id'))]['src'] = $value;
		update_option( 'logo_srcs', $this->settings['logo_srcs'] );
	}

}




