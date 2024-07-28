<?php

namespace Pdw\Pdw_Contact_Form\Db;

use wpdb;
use function dbDelta;

abstract class DbAbstract {

	protected wpdb $wpdb;

	public static function wpdb(): wpdb {
		global $wpdb;

		return $wpdb;
	}

	public static function dbDelta( string $sql ): void {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}