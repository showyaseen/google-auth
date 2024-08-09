<?php

/**
 * Plugin Name:       Google Auth
 * Description:       The Google Auth plugin allows users to create accounts on a WordPress website using their Google accounts.
 * Requires at least: 6.1
 * Requires PHP:      7.4
 * Version:           0.1.0
 * Author:            Yaseen Taha
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ytaha-google-auth
 *
 * @package            YTAHA\GoogleAuth
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

// Support for site-level autoloading.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Plugin version.
if (!defined('YTAHA_GOOGLE_AUTH_VERSION')) {
	define('YTAHA_GOOGLE_AUTH_VERSION', '1.0.0');
}

// Define YTAHA_GOOGLE_AUTH_PLUGIN_FILE.
if (!defined('YTAHA_GOOGLE_AUTH_PLUGIN_FILE')) {
	define('YTAHA_GOOGLE_AUTH_PLUGIN_FILE', __FILE__);
}

// Plugin directory.
if (!defined('YTAHA_GOOGLE_AUTH_DIR')) {
	define('YTAHA_GOOGLE_AUTH_DIR', plugin_dir_path(__FILE__));
}

// Plugin url.
if (!defined('YTAHA_GOOGLE_AUTH_URL')) {
	define('YTAHA_GOOGLE_AUTH_URL', plugin_dir_url(__FILE__));
}

// Assets url.
if (!defined('YTAHA_GOOGLE_AUTH_ASSETS_URL')) {
	define('YTAHA_GOOGLE_AUTH_ASSETS_URL', YTAHA_GOOGLE_AUTH_URL . '/assets');
}

// Shared UI Version.
if (!defined('YTAHA_GOOGLE_AUTH_SUI_VERSION')) {
	define('YTAHA_GOOGLE_AUTH_SUI_VERSION', '2.12.23');
}

// Google Auth Settings Option Name.
if (!defined('YTAHA_GOOGLE_AUTH_OPTION_NAME')) {
	define('YTAHA_GOOGLE_AUTH_OPTION_NAME', 'ytaha_google_auth_settings');
}

// Google Auth Callback Page.
if (!defined('YTAHA_GOOGLE_AUTH_CALLBACK_PAGE')) {
	define('YTAHA_GOOGLE_AUTH_CALLBACK_PAGE', 'ytaha-google-oauth-callback');
}


/**
 * GOOGLE_AUTH class.
 */
class GOOGLE_AUTH
{
	/**
	 * Holds the class instance.
	 *
	 * @var YTAHA_GOOGLE_AUTH $instance
	 */
	private static $instance = null;

	/**
	 * Return an instance of the class
	 *
	 * Return an instance of the YTAHA_GOOGLE_AUTH Class.
	 *
	 * @return YTAHA_GOOGLE_AUTH class instance.
	 *
	 */
	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class initializer.
	 */
	public function load()
	{
		load_plugin_textdomain(
			'ytaha-google-auth',
			false,
			dirname(plugin_basename(__FILE__)) . '/languages'
		);
		\YTAHA\GoogleAuth\Loader::instance();
	}
}

// Init the plugin and load the plugin instance for the first time.
add_action(
	'plugins_loaded',
	function () {
		GOOGLE_AUTH::get_instance()->load();
	}
);