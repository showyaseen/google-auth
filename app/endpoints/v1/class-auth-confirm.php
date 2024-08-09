<?php
/**
 * Google Auth Confirm Endpoint.
 *
 * @package   YTAHA\GoogleAuth
 * @category  Endpoint
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
use Google_Service_Oauth2;
use YTAHA\GoogleAuth\Core\Google_Auth\Auth as GoogleService;
use WP_REST_Server;

/**
 * Class Auth_Confirm
 *
 * Handles the Google Auth confirmation functionality.
 *
 * @category Endpoint
 * @package  YTAHA\GoogleAuth\Endpoints\V1
 */
class Auth_Confirm extends Endpoint {

	/**
	 * API endpoint for the current endpoint.
	 *
	 * @var   string $endpoint
	 */
	protected $endpoint = 'auth/confirm';

	/**
	 * Register the routes for handling auth confirm functionality.
	 *
	 * @return void
	 */
	public function register_routes() {
		// TODO: Add a new route to logout.

		// Route to confirm auth.
		register_rest_route(
			$this->get_namespace(),
			$this->get_endpoint(),
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'auth_confirm_callback' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}

	/**
	 * Callback for auth confirm endpoint.
	 *
	 * @param  WP_REST_Request $request The request object.
	 * @return WP_REST_Response|WP_Error The response or WP_Error on failure.
	 * @throws Exception
	 */
	public function auth_confirm_callback( WP_REST_Request $request ) {
		// Retrieve the authorization code from the request.
		$code = $request->get_param( 'code' );
		if ( empty( $code ) ) {
			return new WP_REST_Response(
				array(
					'status'  => 'error',
					'message' => 'Missing authorization code.',
				),
				400
			);
		}

		GoogleService::instance()->set_up();
		$client = GoogleService::instance()->client();

		try {
			$token = $client->fetchAccessTokenWithAuthCode( $code );
			if ( isset( $token['error'] ) ) {
				throw new \Exception( $token['error_description'] );
			}
		} catch ( \Exception $e ) {
			return new WP_REST_Response(
				array(
					'status'  => 'error',
					'message' => 'Failed to fetch access token: ' . $e->getMessage(),
				),
				400
			);
		}

		// Retrieve user info from Google.
		$oauth2   = new Google_Service_Oauth2( $client );
		$userinfo = $oauth2->userinfo->get();

		if ( empty( $userinfo->email ) ) {
			return new WP_REST_Response(
				array(
					'status'  => 'error',
					'message' => 'Failed to retrieve user email.',
				),
				400
			);
		}

		// Check if the user already exists.
		$user = get_user_by( 'email', $userinfo->email );
		if ( ! $user ) {
			// Create a new user if not exists.
			$password = wp_generate_password();
			$user_id  = wp_create_user( $userinfo->email, $password, $userinfo->email );
			if ( is_wp_error( $user_id ) ) {
				return new WP_REST_Response(
					array(
						'status'  => 'error',
						'message' => 'Failed to create a new user.',
					),
					400
				);
			}
			$user = get_user_by( 'id', $user_id );
		}

		// Log the user in.
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true );

		return new WP_REST_Response(
			array(
				'status'       => 'success',
				'message'      => 'User successfully logged in.',
				'redirect_url' => home_url( '/dashboard' ),
			)
		);
	}
}
