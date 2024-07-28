<div class="wp-block-group has-global-padding is-layout-constrained wp-block-group-is-layout-constrained"
     id="pdw-contact-form">
    <h2 class="has-text-align-center wp-block-post-title"><?php use Pdw\Pdw_Contact_Form\Plugin;

	    echo __( 'Kontakt', Plugin::getTranslationDomain() ) ?></h2>
	<?php if ( true === $formValid ): ?>
		<?php echo get_option( 'pdw-contact-form-settings-success-message' ) ?>
        <p style="border: 1px solid #029E11; padding: 10px; background-color: rgba(0,131,21,0.10);  "><?php echo __( get_option( 'pdw-contact-form-settings-success-message' ), Plugin::getTranslationDomain() ) ?></p>
	<?php else: ?>

        <form action="#pdw-contact-form" method="post">
            <div class="wp-block-group">
				<?php if ( false === $formValid ): ?>
					<?php echo get_option( 'pdw-contact-form-settings-success-message' ) ?>
                    <p style="color: #cc0000;"><?php echo __( get_option( 'pdw-contact-form-settings-error-message' ), Plugin::getTranslationDomain() ) ?></p>
				<?php endif ?>
                <div class="wp-block-columns">
                    <div class="wp-block-column">
                        <label>
                            Name:<br/>
                            <input type="text" name="pdw-contact-form[name]" required maxlength="100"
                                   value="<?php echo $formData['name']['input'] ?? '' ?>"
                                   style="<?php echo( isset( $formData['name']['valid'] ) && $formData['name']['valid'] === false ? 'border: 2px solid #cc0000;' : '' ) ?>">
                        </label>
                    </div>
                </div>
                <div class="wp-block-columns">
                    <div class="wp-block-column">
                        <label>
                            E-Mail:<br/>
                            <input type="email" name="pdw-contact-form[email]" required maxlength="150"
                                   value="<?php echo $formData['email']['input'] ?? '' ?>"
                                   style="<?php echo( isset( $formData['email']['valid'] ) && $formData['email']['valid'] === false ? 'border: 2px solid #cc0000;' : '' ) ?>">
                        </label>
                    </div>
                </div>
                <div class="wp-block-columns">
                    <div class="wp-block-column">
                        <label>
                            Betreff:
                            <input type="text" name="pdw-contact-form[subject]" required maxlength="150"
                                   value="<?php echo $formData['subject']['input'] ?? '' ?>"
                                   style="<?php echo( isset( $formData['subject']['valid'] ) && $formData['subject']['valid'] === false ? 'border: 2px solid #cc0000;' : '' ) ?>">
                        </label>
                    </div>
                </div>
                <div class="wp-block-columns">
                    <div class="wp-block-column">
                        <label>
                            Nachricht:
                            <textarea name="pdw-contact-form[message]" rows="10" required maxlength="3000"
                                      style="<?php echo( isset( $formData['message']['valid'] ) && $formData['message']['valid'] === false ? 'border: 2px solid #cc0000;' : '' ) ?>"><?php echo $formData['message']['input'] ?? '' ?></textarea>
                        </label>
                    </div>
                </div>
                <div class="wp-block-columns">
                    <div class="wp-block-column pdw-scf-buttons">
						<?php
						wp_nonce_field( 'pdw-contact-form-nonce', 'pdw-contact-form[scf-nonce]' )
						?>
                        <input type="submit"
                               value="<?php echo __( 'Absenden', Plugin::getTranslationDomain() ) ?>">
                    </div>
                </div>
            </div>
        </form>
	<?php endif; ?>
</div>

<style>
    #pdw-contact-form input[type=text], #pdw-contact-form input[type=email], #pdw-contact-form textarea {
        width: 100%;
        padding: 5px;
    }

    #pdw-contact-form label {
        width: calc(100% - 10px);
        display: inline-block;
    }

    #pdw-contact-form input:focus, #pdw-contact-form textarea:focus {
        outline-width: 1px;
    }

    .pdw-scf-buttons {
        text-align: right;
    }

</style>