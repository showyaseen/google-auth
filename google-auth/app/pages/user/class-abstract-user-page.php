<?php
/**
 * User Page Abstract Class.
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

use YTAHA\GoogleAuth\Base;

abstract class Abstract_User_Page extends Base {



	/**
	 * The page title.
	 *
	 * @var string
	 */
	private $page_title;

	/**
	 * The page slug.
	 *
	 * @var string
	 */
	protected $page_slug;

	/**
	 * Page Assets.
	 *
	 * @var array
	 */
	protected $page_scripts = array();

	/**
	 * Assets version.
	 *
	 * @var string
	 */
	protected $assets_version = '';

	/**
	 * A unique string id to be used in markup and jsx.
	 *
	 * @var string
	 */
	protected $unique_id = '';

	/**
	 * Scripts Assets.
	 *
	 * @var string
	 */
	protected $assets_path;

	/**
	 * construct admin page abstract.
	 *
	 * @return void

	 */
	public function __construct() {
		$this->assets_version = ! empty( $this->script_data( 'version' ) ) ? $this->script_data( 'version' ) : YTAHA_GOOGLE_AUTH_VERSION;

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		// Add body class to pages body.
		add_filter( 'body_class', array( $this, 'body_classes' ) );
	}

	/**
	 * Gets assets data for given key.
	 *
	 * @param string $key
	 *
	 * @return string|array
	 */
	protected function script_data( string $key = '' ) {
		$raw_script_data = $this->raw_script_data();

		return ! empty( $key ) && ! empty( $raw_script_data[ $key ] ) ? $raw_script_data[ $key ] : '';
	}

	/**
	 * Gets the script data from assets php file.
	 *
	 * @return array
	 */
	protected function raw_script_data(): array {
		static $script_data = null;

		if ( is_null( $script_data ) && file_exists( $this->assets_path ) ) {
			$script_data = include $this->assets_path;
		}

		return (array) $script_data;
	}

	/**
	 * Enqueue assets.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( $this->is_page() ) {
			$this->prepare_assets();
			if ( ! empty( $this->page_scripts ) ) {
				foreach ( $this->page_scripts as $handle => $page_script ) {
					wp_register_script(
						$handle,
						$page_script['src'],
						$page_script['deps'],
						$page_script['ver'],
						$page_script['strategy']
					);

					if ( ! empty( $page_script['localize'] ) && ! empty( $page_script['object_name'] ) ) {
								wp_localize_script( $handle, $page_script['object_name'], $page_script['localize'] );
					}

					wp_enqueue_script( $handle );

					if ( ! empty( $page_script['style_src'] ) ) {
						wp_enqueue_style( $handle, $page_script['style_src'], array(), $this->assets_version );
					}
				}
			}
		}
	}

	/**
	 * Adds the SUI class on markup body.
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	public function body_classes( $classes = '' ) {
		if ( ! $this->is_page() ) {
			return $classes;
		}

		$classes[] = 'sui-' . str_replace( '.', '-', YTAHA_GOOGLE_AUTH_SUI_VERSION );

		return $classes;
	}

	protected function is_page(): bool {
		global $wp;
		return ( $this->page_slug === $wp->request );
	}

	/**
	 * Prints the wrapper element which React will use as root.
	 *
	 * @return void
	 */
	public function view() {
	}

	/**
	 * Prepares assets.
	 *
	 * @return void
	 */
	public function prepare_assets() {
	}
}
