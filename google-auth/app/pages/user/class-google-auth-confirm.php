<?php
/**
 * Google Auth Confirm User Page.
 *
 * @package   YTAHA\GoogleAuth
 * @category  Endpoint
 * @author    Yaseen Taha <showyaseen@hotmail.com>
 * @license   GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link      showyaseen@hotmail.com
 */

namespace YTAHA\GoogleAuth\App\Pages\User;

// Abort if called directly.
defined( 'WPINC' ) || die;

class Google_Auth_Confirm extends Abstract_User_Page {




	/**
	 * A unique string id to be used in markup and jsx.
	 *
	 * @var string
	 */
	public $unique_id = '';

	/**
	 * Initializes the page.
	 *
	 * @return void

	 */
	public function init() {
		$this->page_title     = __( 'Google OAuth Callback', 'ytaha-google-auth' );
		$this->page_slug      = YTAHA_GOOGLE_AUTH_CALLBACK_PAGE;
		$this->assets_version = ! empty( $this->script_data( 'version' ) ) ? $this->script_data( 'version' ) : YTAHA_GOOGLE_AUTH_VERSION;
		$this->unique_id      = "{$this->page_slug}-{$this->assets_version}";
		$this->assets_path    = YTAHA_GOOGLE_AUTH_DIR . 'assets/js/ytaha-confirm-settings-page.min.asset.php';

		add_action( 'template_redirect', array( $this, 'ytaha_custom_google_oauth_callback_page' ) );
	}

	function ytaha_custom_google_oauth_callback_page() {
		// Check if the current URL is the one we want to intercept as auth confirm page
		if ( $this->is_page() ) {
			$this->view();
		}
	}

	/**
	 * Prints the wrapper element which React will use as root.
	 *
	 * @return void
	 */
	public function view() {
		$title     = $this->page_title;
		$unique_id = $this->unique_id;
		include YTAHA_GOOGLE_AUTH_DIR . 'app/templates/auth-confirm.php';
		exit;
	}

	/**
	 * Prepares assets.
	 *
	 * @return void
	 */
	public function prepare_assets() {

		if ( ! is_array( $this->page_scripts ) ) {
			$this->page_scripts = array();
		}

		$handle       = 'ytaha_google_auth_confirmpage';
		$src          = YTAHA_GOOGLE_AUTH_ASSETS_URL . '/js/ytaha-confirm-settings-page.min.js';
		$style_src    = YTAHA_GOOGLE_AUTH_ASSETS_URL . '/css/ytaha-confirm-settings-page.min.css';
		$dependencies = ! empty( $this->script_data( 'dependencies' ) )
		? $this->script_data( 'dependencies' )
		: array(
			'react',
			'wp-element',
			'wp-i18n',
			'wp-is-shallow-equal',
			'wp-polyfill',
		);

		$this->page_scripts[ $handle ] = array(
			'src'         => $src,
			'style_src'   => $style_src,
			'deps'        => $dependencies,
			'ver'         => $this->assets_version,
			'strategy'    => true,
			'object_name' => 'ytahaGoogleAuthConfirm',
			'localize'    => array(
				'domElementId'        => $this->unique_id,
				'restEndpointConfirm' => \YTAHA\GoogleAuth\Endpoints\V1\Auth_Confirm::instance()->get_endpoint_url(),
				'restEndpointNonce'   => wp_create_nonce( 'wp_rest' ),
				'successUrl'          => home_url(),
			),
		);
	}
}
