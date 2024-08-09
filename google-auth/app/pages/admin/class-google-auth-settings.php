<?php
/**
 * Google Auth Settings Admin Page Class.
 *
 * @package   YTAHA\GoogleAuth
 * @category  Endpoint
 * @author    Yaseen Taha <showyaseen@hotmail.com>
 * @license   GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link      showyaseen@hotmail.com
 */

namespace YTAHA\GoogleAuth\App\Pages\Admin;

// Abort if called directly.
defined( 'WPINC' ) || die;

class Google_Auth_Settings extends Abstract_Admin_Page {

	/**
	 * Google auth credentials.
	 *

	 *
	 * @var array
	 */
	private $creds = array();

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private $option_name = YTAHA_GOOGLE_AUTH_OPTION_NAME;


	/**
	 * Initializes the page.
	 *

	 * @return void
	 */
	public function init() {
		$this->page_title  = __( 'Google Auth', 'ytaha-google-auth' );
		$this->page_slug   = 'ytaha_google_auth_google_auth';
		$this->creds       = get_option( $this->option_name, array() );
		$this->unique_id   = "{$this->page_slug}-{$this->assets_version}";
		$this->assets_path = YTAHA_GOOGLE_AUTH_DIR . 'assets/js/ytaha-auth-settings-page.min.asset.php';
	}

	/**
	 * Registers the admin page.
	 *
	 * @return void
	 */
	public function register_admin_page() {
		$page = add_menu_page(
			'Google Auth setup',
			$this->page_title,
			'manage_options',
			$this->page_slug,
			array( $this, 'view' ),
			'dashicons-google',
			6
		);

		add_action( 'load-' . $page, array( $this, 'prepare_assets' ) );
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

		$handle       = 'ytaha_google_auth_google_authpage';
		$src          = YTAHA_GOOGLE_AUTH_ASSETS_URL . '/js/ytaha-auth-settings-page.min.js';
		$style_src    = YTAHA_GOOGLE_AUTH_ASSETS_URL . '/css/ytaha-auth-settings-page.min.css';
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
			'object_name' => 'ytahaGoogleAuth',
			'localize'    => array(
				'domElementId'     => $this->unique_id,
				'clientID'         => $this->creds['client_id'] ?? '',
				'clientSecret'     => $this->creds['client_secret'] ?? '',
				'restEndpointSave' => \YTAHA\GoogleAuth\Endpoints\V1\Auth_Settings::instance()->get_endpoint_url(),
				'returnUrl'        => home_url( YTAHA_GOOGLE_AUTH_CALLBACK_PAGE ),
			),
		);
	}
}
