<?php

namespace Pdw\Pdw_Contact_Form\ContactForm;

use Pdw\Pdw_Contact_Form\Db\Message;
use Pdw\Pdw_Contact_Form\Plugin;

class ContactForm {

	public function render(): bool|string {
		ob_start();

		$formData  = [];
		$formValid = null;

		if ( ! empty( $_POST['pdw-contact-form'] ) ) {
			$processFormData = $this->processFormData();
			$formData        = $processFormData['formData'];
			$formValid       = $processFormData['valid'];

			if ( $formValid ) {
				$this->saveToDb( $formData );
				$this->sendMail( $formData );
			}
		}

		include( PDW_CONTACT_FORM_PLUGIN_DIR . "public/partials/contact-form/contact-form.php" );

		return ob_get_clean();
	}

	private function processFormData(): array {
		$formData = [
			'name'      => [
				'valid'          => false,
				'error_messages' => [],
				'input'          => $this->filterPostData( $_POST['pdw-contact-form']['name'] ?? null ),
			],
			'email'     => [
				'valid'          => false,
				'error_messages' => [],
				'input'          => $this->filterPostData( $_POST['pdw-contact-form']['email'] ?? null ),
			],
			'subject'   => [
				'valid'          => false,
				'error_messages' => [],
				'input'          => $this->filterPostData( $_POST['pdw-contact-form']['subject'] ?? null ),
			],
			'message'   => [
				'valid'          => false,
				'error_messages' => [],
				'input'          => $this->filterPostData( $_POST['pdw-contact-form']['message'] ?? null ),
			],
			'scf-nonce' => [
				'error_messages' => [],
				'valid'          => false,
			]
		];

		if ( ! wp_verify_nonce( $_POST['pdw-contact-form']['scf-nonce'], 'pdw-contact-form-nonce' ) ) {
			$formData['scf-nonce']['error_messages'][] = __( 'Es ist etwas schief gelaufen.', Plugin::getTranslationDomain() );
		}

		if ( empty( $formData['name']['input'] ) ) {
			$formData['name']['error_messages'][] = __( 'Bitte füllen Sie die benötigten Felder aus.', Plugin::getTranslationDomain() );
		}

		if ( empty( $formData['email']['input'] ) ) {
			$formData['email']['error_messages'][] = __( 'Bitte füllen Sie die benötigten Felder aus.', Plugin::getTranslationDomain() );
		}

		if ( ! filter_var( $formData['email']['input'], FILTER_VALIDATE_EMAIL ) ) {
			$formData['email']['error_messages'][] = __( 'Bitte geben Sie eine gültige E-Mail Adresse ein.', Plugin::getTranslationDomain() );
		}

		if ( empty( $formData['subject']['input'] ) ) {
			$formData['subject']['error_messages'][] = __( 'Bitte füllen Sie die benötigten Felder aus.', Plugin::getTranslationDomain() );
		}

		if ( empty( $formData['message']['input'] ) ) {
			$formData['message']['error_messages'][] = __( 'Bitte füllen Sie die benötigten Felder aus.', Plugin::getTranslationDomain() );
		}

		foreach ( $formData as $fieldKey => $options ) {
			$formData[ $fieldKey ]['valid'] = empty( $options['error_messages'] );
		}

		$validValues = array_column( $formData, 'valid' );

		return [
			'valid'    => ! in_array( false, $validValues, true ),
			'formData' => $formData
		];

	}

	private function filterPostData( mixed $postData ): ?string {
		return sanitize_text_field( stripslashes( strip_tags( trim( $postData ?? '' ) ) ) );
	}

	private function saveToDb( array $formData ): void {
		Message::addMessage( $formData['name']['input'], $formData['email']['input'], $formData['subject']['input'], $formData['message']['input'] );
	}

	private function sendMail( array $formData ): void {


		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		$body = 'Neue Anfrage: <br><br>
Name: ' . $formData['name']['input'] . '<br>
E-Mail: ' . $formData['email']['input'] . '<br>
Betreff: ' . $formData['subject']['input'] . '<br>
Nachricht: ' . $formData['message']['input'] . '<br>

';

		wp_mail(
			get_option( 'pdw-contact-form-settings-to-email' ),
			'Neue Kontaktanfrage',
			$body,
			$headers
		);
	}
}