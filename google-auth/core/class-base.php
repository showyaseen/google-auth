<?php
/**
 * Base abstract class to be inherited by other classes
 *
 * @link  showyaseen@hotmail.com

 *
 * @author  Yaseen Taha (showyaseen@hotmail.com)
 * @package YTAHA\GoogleAuth
 *
 */

namespace YTAHA\GoogleAuth;

use YTAHA\GoogleAuth\Singleton;

// Abort if called directly.
defined( 'WPINC' ) || die;

/**
 * Class Base
 *
 * @package YTAHA\GoogleAuth
 */
abstract class Base extends Singleton {

	/**
	 * Getter method.
	 *
	 * Allows access to extended site properties.
	 *
	 * @param string $key Property to get.
	 *
	 * @return mixed Value of the property. Null if not available.

	 */
	public function __get( $key ) {
		// If set, get it.
		if ( isset( $this->{$key} ) ) {
			return $this->{$key};
		}

		return null;
	}

	/**
	 * Setter method.
	 *
	 * Set property and values to class.
	 *
	 * @param string $key   Property to set.
	 * @param mixed  $value Value to assign to the property.
	 *

	 */
	public function __set( $key, $value ) {
		$this->{$key} = $value;
	}
}
