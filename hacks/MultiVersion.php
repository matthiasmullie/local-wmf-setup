<?php

/**
 * wmf-config/CommonSettings.php will expect a MWMultiVersion setup;
 * this will emulate that functionality for the sake of CommonSettings.php,
 * even though we don't have a real multiversion setup.
 */
class MWMultiVersion {
	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new MWMultiVersion();
		}
		return self::$instance;
	}

	/**
	 * This will load settings of the returned wiki
	 *
	 * @return string
	 */
	public function getDatabase() {
		global $wiki;
		return $wiki;
	}

	/**
	 * Used for caches etc; not really important here.
	 *
	 * @return string
	 */
	public function getVersionNumber() {
		return 'local';
	}

	/**
	 * Used for caches etc; not really important here.
	 * Also used to load ExtensionMessages-<value>.php
	 *
	 * @return string
	 */
	public function getExtendedVersionNumber() {
		return 'local';
	}
}
