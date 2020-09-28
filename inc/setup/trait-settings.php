<?php

require_once __DIR__.'\..\classes\class-constants.php';

trait Settings {
	protected static $instance = null;

	/**
	 * Post_Modifier_Settings constructor.
	 *
	 * @param array $settings
	 */
	private function __construct(  ) {
		foreach (Constants::settings_defaults() as $name => $default_value){
			$this->settings[$name] = get_option($name, $default_value);
		}

	}

	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
		}

		return self::$instance;
	}

}
