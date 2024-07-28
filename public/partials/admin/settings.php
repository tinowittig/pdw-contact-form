<form method="post" action="options.php">
	<?php use Pdw\Pdw_Contact_Form\Plugin;

	settings_fields( 'pdw-contact-form-settings' ); ?>
	<?php do_settings_sections( 'pdw-contact-form-settings' ); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
				<?php esc_html_e( 'Empfänger für Kontaktanfragen:', Plugin::getTranslationDomain() ); ?>
            </th>
            <td>
                <input type="text" name="pdw-contact-form-settings-to-email"
                       value="<?php echo get_option( 'pdw-contact-form-settings-to-email' ); ?>"/></td>
        </tr>
        <tr valign="top">
            <th scope="row">
				<?php esc_html_e( 'Fehlermeldung', Plugin::getTranslationDomain() ); ?>
            </th>
            <td>
                <input type="text" name="pdw-contact-form-settings-error-message"
                       value="<?php echo get_option( 'pdw-contact-form-settings-error-message' ); ?>"/></td>
        </tr>
        <tr valign="top">
            <th scope="row">
				<?php esc_html_e( 'Erfolgsmeldung:', Plugin::getTranslationDomain() ); ?>
            </th>
            <td>
                <input type="text" name="pdw-contact-form-settings-success-message"
                       value="<?php echo get_option( 'pdw-contact-form-settings-success-message' ); ?>"/></td>
        </tr>
    </table>
	<?php submit_button(); ?>
</form>