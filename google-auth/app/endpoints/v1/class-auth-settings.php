<?php

/**
 * Google Auth Settings Endpoint.
 *
 * @category  Endpoint
 * @package   YTAHA\GoogleAuth
 * @author    Yaseen Taha <showyaseen@hotmail.com>
 * @license   GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link      showyaseen@hotmail.com
 */

namespace YTAHA\GoogleAuth\Endpoints\V1;

// Abort if called directly.
defined( 'WPINC' ) || die;

use YTAHA\GoogleAuth\Endpoint;
use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

/**
 * Class Auth_Settings
 *
 * Handles Google Auth functionality.
 *
 * @category Endpoint
 * @package  YTAHA\GoogleAuth\Endpoints\V1
 * @author   Yaseen Taha <showyaseen@hotmail.com>
 * @license  GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link     showyaseen@hotmail.com
 */
class Auth_Settings extends Endpoint {



	/**
	 * API endpoint for the current endpoint.
	 *

	 * @var   string $endpoint
	 */
	protected $endpoint = 'auth/auth-url';

	/**
	 * Register the routes for handling auth functionality.
	 *

	 * @return void
	 */
	public function register_routes() {
		// TODO: Add a new route to logout.

		// Route to auth URL.
		register_rest_route(
			$this->get_namespace(),
			$this->get_endpoint(),
			array(
				array(
					'methods'             => 'POST',
					'args'                => array(
						'client_id'     => array(
							'required'    => true,
							'description' => __(
								'The client ID from Google API project.',
								'ytaha-google-auth'
							),
							'type'        => 'string',
						),
						'client_secret' => array(
							'required'    => true,
							'description' => __(
								'The client secret from Google API project.',
								'ytaha-google-auth'
							),
							'type'        => 'string',
						),
					),
					'callback'            => array( $this, 'save_auth_callback' ),
					'permission_callback' => array( $this, 'edit_permission' ),
				),
			)
		);

		add_filter( 'ytaha_google_auth_rest_settings_permission', array( $this, 'settings_permission_check' ) );
	}

	/**
	 * Check permissions for the request.
	 *

	 * @return bool|WP_Error True if the request has access, WP_Error otherwise.
	 */
	public function settings_permission_check( $capable ) {
		if ( ! $capable ) {
			return new WP_Error(
				'rest_forbidden',
				__(
					'You do not have permissions to perform this action.',
					'ytaha-google-auth'
				),
				array( 'status' => 401 )
			);
		}
		return $capable;
	}

	/**
	 * Callback for auth-url endpoint.
	 *

	 * @param  WP_REST_Request $request The request object.
	 * @return WP_REST_Response|WP_Error The response or WP_Error on failure.
	 */
	public function save_auth_callback( WP_REST_Request $request ) {
		$client_id     = sanitize_text_field( $request->get_param( 'client_id' ) );
		$client_secret = sanitize_text_field( $request->get_param( 'client_secret' ) );

		$this->save_credentials( $client_id, $client_secret );
		return new WP_REST_Response(
			array(
				'message' => __(
					'Credentials saved successfully.',
					'ytaha-google-auth'
				),
			),
			200
		);
	}

	/**
	 * Save the client ID and secret.
	 *

	 * @param  string $client_id     The client ID.
	 * @param  string $client_secret The client secret.
	 * @return void
	 */
	public function save_credentials( $client_id, $client_secret ) {
		$current_settings = get_option( YTAHA_GOOGLE_AUTH_OPTION_NAME, false );
		$new_settings     = array(
			'client_id'     => $client_id,
			'client_secret' => $client_secret,
		);

		if ( $current_settings !== false ) {
			update_option( YTAHA_GOOGLE_AUTH_OPTION_NAME, $new_settings );
		} else {
			add_option( YTAHA_GOOGLE_AUTH_OPTION_NAME, $new_settings );
		}
	}
}
