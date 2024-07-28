<?php

namespace Pdw\Pdw_Contact_Form\Db;

class Message extends DbAbstract {

	public static function addMessage( string $name, string $email, string $subject, string $message ): void {
		self::wpdb()->insert( self::wpdb()->prefix . 'pdw_contact_form_message', [
			'name'    => $name,
			'email'   => $email,
			'subject' => $subject,
			'message' => $message,
		] );

	}

}