<?php

/**
 * Google Auth Class.
 *
 * @link          showyaseen@hotmail.com

 *
 * @author        Yaseen Taha (showyaseen@hotmail.com)
 * @package       YTAHA\GoogleAuth
 *
 */

namespace YTAHA\GoogleAuth\Core\Google_Auth;

// Abort if called directly.
defined('WPINC') || die;

use YTAHA\GoogleAuth\Base;
use Google\Client;

class Auth extends Base
{
	/**
	 * Google client instance.
	 *

	 *
	 * @var Client
	 */
	private $client;

	/**
	 * client id for google api auth.
	 *

	 *
	 * @var string $client_id
	 */
	private $client_id = '';

	/**
	 * client secret for google api auth.
	 *

	 *
	 * @var string $client_secret
	 */
	private $client_secret = '';

	/**
	 * Getter method for Client instance.
	 *
	 * It will always return the existing client instance.
	 * If you need new instance set $new_instance param as true.
	 *
	 * @param bool $new_instance To get new instance.
	 *
	 * @return Client

	 */
	public function client($new_instance = false)
	{
		// If requested for new instance.
		if ($new_instance || !$this->client instanceof Client) {
			// Set new instance.
			$this->client = new Client();

			// Set our application name.
			$this->client->setApplicationName(__('YTAHA Google Auth', 'ytaha-google-auth'));
		}

		return $this->client;
	}

	/**
	 * Set up client id and client secret.
	 *
	 * @param string $client_id
	 * @param string $client_secret
	 *
	 * @return boolean
	 */
	public function set_up(string $client_id = '', string $client_secret = ''): bool
	{
		$client_id     = !empty($client_id) ? $client_id : $this->get_client_id();
		$client_secret = !empty($client_secret) ? $client_secret : $this->get_client_secret();

		$this->client()->setClientId($client_id);
		$this->client()->setClientSecret($client_secret);
		$this->client()->setRedirectUri(home_url(YTAHA_GOOGLE_AUTH_CALLBACK_PAGE));
		$this->client()->addScope('profile');
		$this->client()->addScope('email');

		return true;
	}

	/**
	 * Gets the client id.
	 *
	 * @return string
	 */
	private function get_client_id()
	{
		if (empty($this->client_id)) {
			$settings = $this->get_settings();

			$this->client_id = !empty($settings['client_id']) ? $settings['client_id'] : '';
		}

		return $this->client_id;
	}

	/**
	 * Gets the client secret.
	 *
	 * @return string
	 */
	private function get_client_secret()
	{
		if (empty($this->client_secret)) {
			$settings = $this->get_settings();

			$this->client_secret = !empty($settings['client_secret']) ? $settings['client_secret'] : '';
		}

		return $this->client_secret;
	}

	public function get_auth_url()
	{
		return $this->client()->createAuthUrl();
	}

	protected function get_settings()
	{
		static $settings = null;

		if (is_null($settings)) {
			$settings = get_option('ytaha_google_auth_settings');
		}

		return $settings;
	}
}
