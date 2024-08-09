<?php

/**
 * Class to boot up plugin.
 *
 * @link  showyaseen@hotmail.com

 *
 * @author  Yaseen Taha (showyaseen@hotmail.com)
 * @package YTAHA\GoogleAuth
 *
 */

namespace YTAHA\GoogleAuth;

use YTAHA\GoogleAuth\Base;

// If this file is called directly, abort.
defined('WPINC') || die;

final class Loader extends Base
{

	/**
	 * Settings helper class instance.
	 *

	 * @var   object
	 */
	public $settings;

	/**
	 * Minimum supported php version.
	 *

	 * @var   float
	 */
	public $php_version = '7.4';

	/**
	 * Minimum WordPress version.
	 *

	 * @var   float
	 */
	public $wp_version = '6.1';

	/**
	 * Initialize functionality of the plugin.
	 *
	 * This is where we kick-start the plugin by defining
	 * everything required and register all hooks.
	 *

	 * @access protected
	 * @return void
	 */
	protected function __construct()
	{
		if (!$this->can_boot()) {
			return;
		}

		$this->init();
	}

	/**
	 * Main condition that checks if plugin parts should continue loading.
	 *
	 * @return bool
	 */
	private function can_boot()
	{
		/**
		 * Checks
		 *  - PHP version
		 *  - WP Version
		 * If not then return.
		 */
		global $wp_version;

		return (
			version_compare(PHP_VERSION, $this->php_version, '>') &&
			version_compare($wp_version, $this->wp_version, '>')
		);
	}

	/**
	 * Register all the actions and filters.
	 *

	 * @access private
	 * @return void
	 */
	private function init()
	{
		// Register Pages.
		App\Pages\Admin\Google_Auth_Settings::instance()->init();
		App\Pages\User\Google_Auth_Confirm::instance()->init();

		// Register Endpoints
		Endpoints\V1\Auth_Settings::instance();
		Endpoints\V1\Auth_Confirm::instance();

		// Register Shortcodes
		Shortcodes\Confirm_Shortcode::instance();
	}
}
