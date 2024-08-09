<?php
/**
 * Auth Confirm Template
 *
 * @package   YTAHA\GoogleAuth
 * @category  Template
 * @version   1.0.1
 * @license   GPL-2.0+ https://www.gnu.org/licenses/gpl-2.0.html
 * @link      showyaseen@hotmail.com
 */

namespace YTAHA\GoogleAuth\App\Templates;

// Ensure this file is called by a WordPress process.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo esc_html( $title ); ?></title>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="<?php echo esc_attr( $unique_id ); ?>" class="sui-wrap"></div>

	<?php wp_footer(); ?>
</body>

</html>
