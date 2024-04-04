<?php

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Pixova_Custom_Upload' ) ) {
	class Pixova_Custom_Upload extends WP_Customize_Upload_Control {

		protected function get_value() {
			$setting_value = Pixova_Lite_Helper::get_pixova_setting( $this->id );
			if ( false === $setting_value ) {
				return $this->value();
			} else {
				return $setting_value;
			}
		}

		public function to_json() {
			parent::to_json();
			$value = $this->get_value();
			if ( $value ) {
				// Get the attachment model for the existing file.
				$attachment_id = attachment_url_to_postid( $value );
				if ( $attachment_id ) {
					$this->json['attachment'] = wp_prepare_attachment_for_js( $attachment_id );
				}
			}
		}

	}
} // End if().
