<?php

namespace Pdw\Pdw_Contact_Form\Db;

class Setup extends DbAbstract {

	public static function createTable(): void {
		$sql = "CREATE TABLE IF NOT EXISTS `" . self::wpdb()->prefix . "pdw_contact_form_message` (
    		id int(11) NOT NULL AUTO_INCREMENT,
    		createdAt datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
    		name varchar(100) NOT NULL,
		    email varchar(150) NOT NULL,
		    subject varchar(150) NOT NULL,
		    message text NOT NULL,
    		UNIQUE KEY id (id)
		) " . self::wpdb()->get_charset_collate() . ";";

		self::dbDelta( $sql );
	}

	public static function dropTable(): void {
		self::wpdb()->query( "DROP TABLE IF EXISTS `" . self::wpdb()->prefix . "pdw_contact_form_message`" );
	}

}