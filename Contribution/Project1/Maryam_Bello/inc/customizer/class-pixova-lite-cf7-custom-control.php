<?php

if ( ! defined( 'ABSPATH' ) ) {
	die(); // no direct access
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Customize for Contact Form 7, extend the WP Customizer
 *
 * adds a custom control for rendering created contact forms in the customizer.
 * @since Pixova Lite 1.0.0
 */
if ( ! class_exists( 'Pixova_Lite_CF7_Custom_Control' ) ) {
	class Pixova_Lite_CF7_Custom_Control extends WP_Customize_Control {


		/**
		 * Returns true / false if the plugin: Contact Form 7 is activated;
		 *
		 * This right here disables the control for selecting a contact form IF the plugin isn\'t active
		 *
		 * @since Pixova Lite 1.15
		 *
		 * @return bool
		 */
		public function active_callback() {

			require_once ABSPATH . 'wp-admin/includes/plugin.php';

			if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
				return true;
			} else {
				return false;
			}
		}

		public function pixova_lite_get_cf7_forms() {

			// no more php warnings
			$contact_forms = array();

			// check if CF7 is activated
			if ( $this->active_callback() ) {

				$args = array(
					'post_type'      => 'wpcf7_contact_form',
					'post_status'    => 'publish',
					'posts_per_page' => - 1,
				);

				$cf7forms = new WP_Query( $args );
				if ( $cf7forms->have_posts() ) {
					foreach ( $cf7forms->posts as $cf7form ) {
						$contact_forms[ $cf7form->ID ] = $cf7form->post_title;
					}
				} else {
					$contact_forms[0] = __( 'No contact forms found', 'pixova-lite' );
				}
			}

			return $contact_forms;
		}

		public function render_content() {
			$pixova_lite_contact_forms = $this->pixova_lite_get_cf7_forms();

			if ( ! empty( $pixova_lite_contact_forms ) ) { ?>

				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?> style="width:100%;">

				<?php

				echo '<option selected="selected" value="default">' . __( 'Select your contact form', 'pixova-lite' ) . '</option>';

				foreach ( $pixova_lite_contact_forms as $form_id => $form_title ) {
					echo '<option value="' . sanitize_key( $form_id ) . '" >' . esc_html( $form_title ) . '</option>';
				}

				echo '</select>';
			}
		}
	}
}// End if().
