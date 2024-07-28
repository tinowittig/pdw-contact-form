<?php

namespace Pdw\Pdw_Contact_Form\Admin;

use Pdw\Pdw_Contact_Form\Admin\Table\MessageListTable;
use Pdw\Pdw_Contact_Form\Plugin;

class MessageListPage {
	public const SCREEN = 'pdw-contact-form-message-list';

	public function addPage(): void {

		add_menu_page(
			__( 'PDW Kontaktformular', Plugin::getTranslationDomain() ),
			__( 'PDW Kontaktformular', Plugin::getTranslationDomain() ),
			'manage_options',
			self::SCREEN,
			[
				$this,
				'renderPage',
			]
		);
	}

	public function renderPage(): void {
		wp_enqueue_script( 'jquery-ui-dialog' ); // jquery and jquery-ui should be dependencies, didn't check though...
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		$messageListTable = new MessageListTable();
		$messageListTable->prepare_items();
		?>
        <div class="wrap">
            <h1>
				<?php esc_html_e( 'PDW Kontaktformular', Plugin::getTranslationDomain() ); ?>
            </h1>
            <form id="pdw-contact-form-message-list-form" method="post">
                <div>
					<?php $messageListTable->display(); ?>
                </div>
            </form>
        </div>
		<?php
	}
}