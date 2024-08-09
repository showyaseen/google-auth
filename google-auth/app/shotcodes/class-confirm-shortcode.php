<?php
/**
 * Confirm Shortcode Class
 *
 * @package   YTAHA\GoogleAuth
 * @category  Endpoint
 * @version   1.0.1
 * @license   GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link      showyaseen@hotmail.com
 */

namespace YTAHA\GoogleAuth\Shortcodes;

use YTAHA\GoogleAuth\Core\Google_Auth\Auth;

/**
 * Class Confirm_Shortcode
 *
 * Handles the Google authentication link shortcode.
 *
 * @package YTAHA\GoogleAuth\Shortcodes
 */
class Confirm_Shortcode extends \YTAHA\GoogleAuth\Singleton {

	/**
	 * Confirm_Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'google_auth_link', array( $this, 'google_auth_link' ) );
	}

	/**
	 * Generates the Google authentication link or greeting message.
	 *
	 * @return string
	 */
	public function google_auth_link() {
		if ( is_user_logged_in() ) {
			return sprintf( __( 'Hello, %s!', 'ytaha-google-auth' ), esc_html( wp_get_current_user()->display_name ) );
		} else {
			$google_auth = Auth::instance();
			$google_auth->set_up();
			return sprintf( '<a href="%s">%s</a>', esc_url( $google_auth->get_auth_url() ), __( 'Login with Google', 'ytaha-google-auth' ) );
		}
	}
}
