<?php

namespace Pdw\Pdw_Contact_Form\Hook;

use Pdw\Pdw_Contact_Form\Db\Setup;

class UninstallHook {

	public function __invoke(): void {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		Setup::dropTable();
	}
}