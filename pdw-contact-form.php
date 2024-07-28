<?php
/**
 * Plugin Name:       PDW contact form
 * Description:       simple contact form
 * Requires at least: 6.1
 * Requires PHP:      8.1
 * Version:           1.0.0
 * Author:            Tino Wittig
 * Author URI:        https://www.prodoweb.de
 * Plugin URI:        https://PLUGIN_URI/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 *
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PDW_CONTACT_FORM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PDW_CONTACT_FORM_MAIN_FILE', __FILE__ );
define( 'PDW_CONTACT_FORM_VERSION', '1.0.0' );

require __DIR__ . '/vendor/autoload.php';

use Pdw\Pdw_Contact_Form\Plugin;

Plugin::run( __FILE__ );
