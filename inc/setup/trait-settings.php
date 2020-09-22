<?php

trait Settings {
	protected static $instance = null;
	/**
	 * Post_Modifier_Settings constructor.
	 *
	 * @param array $settings
	 */
	private function __construct(  ) {
		$this->settings = array(
			'plugin_state'  => get_option( 'plugin_state', 'off' ),
			'special_word'  => get_option( 'special_word', 'post' ),
			'header_color'  => get_option( 'header_color', '000000' ),
			'content_color' => get_option( 'content_color', '000000' ),
		);
	}

	public static function getInstance(){
		if(self::$instance === null){
			self::$instance = new self();
		}

		return self::$instance;
	}

}
