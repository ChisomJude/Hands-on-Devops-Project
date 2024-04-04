<?php

if ( ! defined( 'ABSPATH' ) ) {
	die(); // no direct access
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Customize for Numbers, extend the WP customizer
 *
 *@since Pixova Lite 1.0.0
 */
if ( ! class_exists( 'Pixova_Lite_Number_Custom_Control' ) ) {
	class Pixova_Lite_Number_Custom_Control extends WP_Customize_Control {

		public $type = 'number';

		protected function get_value() {
			$setting_value = Pixova_Lite_Helper::get_pixova_setting( $this->id );
			if ( false === $setting_value ) {
				return $this->value();
			} else {
				return $setting_value;
			}
		}

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->get_value() ); ?>"/>
			</label>
			<?php
		}
	}
}
