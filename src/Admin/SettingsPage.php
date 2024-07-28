<?php

namespace Pdw\Pdw_Contact_Form\Admin;

use Pdw\Pdw_Contact_Form\Plugin;

class SettingsPage {
	public const SCREEN = 'pdw-contact-form-settings';

	public function addPage(): void {

		add_submenu_page(
			MessageListPage::SCREEN,
			__( 'Einstellungen', Plugin::getTranslationDomain() ),
			__( 'Einstellungen', Plugin::getTranslationDomain() ),
			'manage_options',
			self::SCREEN,
			[
				$this,
				'renderPage',
			]
		);
	}

	public function renderPage(): void {

		?>
        <div class="pdw-contact-form-wrap">
            <h1>
				<?php esc_html_e( 'PDW Kontaktformular', Plugin::getTranslationDomain() ); ?>
            </h1>
            <div>
				<?php include PDW_CONTACT_FORM_PLUGIN_DIR . "public/partials/admin/settings.php"; ?>
            </div>
        </div>
		<?php
	}
}