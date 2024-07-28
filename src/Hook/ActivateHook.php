<?php

namespace Pdw\Pdw_Contact_Form\Hook;

use Pdw\Pdw_Contact_Form\Db\Setup;

class ActivateHook {

	public function __invoke(): void {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		Setup::createTable();

		add_option( 'pdw-contact-form-settings-to-email', get_option( 'admin_email' ) );
		add_option( 'pdw-contact-form-settings-success-message', 'Vielen Dank für die Nachricht. Wir werden uns umgehend melden.' );
		add_option( 'pdw-contact-form-settings-error-message', 'Bitte füllen Sie die benötigten Felder aus.' );

	}
}