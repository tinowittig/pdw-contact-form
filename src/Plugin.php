<?php

namespace Pdw\Pdw_Contact_Form;

use Pdw\Pdw_Contact_Form\Admin\MessageListPage;
use Pdw\Pdw_Contact_Form\Admin\SettingsPage;
use Pdw\Pdw_Contact_Form\ContactForm\ContactForm;
use Pdw\Pdw_Contact_Form\Hook\ActivateHook;
use Pdw\Pdw_Contact_Form\Hook\UninstallHook;

class Plugin {

	public static string $entryPoint;

	public static function run( string $entryPoint ): void {
		self::$entryPoint = $entryPoint;

		register_activation_hook( $entryPoint, new ActivateHook() );
		register_uninstall_hook( $entryPoint, new UninstallHook() );
		load_plugin_textdomain( self::getPluginName() );
		add_action( 'admin_init', function () {
			register_setting( 'pdw-contact-form-settings', 'pdw-contact-form-settings-to-email' );
			register_setting( 'pdw-contact-form-settings', 'pdw-contact-form-settings-success-message' );
			register_setting( 'pdw-contact-form-settings', 'pdw-contact-form-settings-error-message' );
		} );
		add_action( 'init', function () {
			add_shortcode( 'pdw-contact-form', [ new ContactForm(), 'render' ] );
		} );
		add_action( 'admin_menu', [ new MessageListPage(), 'addPage' ] );
		add_action( 'admin_menu', [ new SettingsPage(), 'addPage' ] );

		add_filter( 'plugin_action_links_' . plugin_basename( PDW_CONTACT_FORM_MAIN_FILE ), function ( $actions ) {
			$settingLink = '<a href="' . admin_url( 'admin.php?page=' . SettingsPage::SCREEN ) . '">' . __( 'Einstellungen', Plugin::getTranslationDomain() ) . '</a>';

			array_unshift( $actions, $settingLink );

			return $actions;
		} );
	}

	public static function getPluginName(): string {
		return 'pdw-contact-form';
	}

	public static function getTranslationDomain(): string {
		return 'pdw-contact-form';
	}
}