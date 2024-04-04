<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Notify_System
 */
class Pixova_Notify_System extends Epsilon_Notify_System {
	/**
	 * @return bool
	 */
	public static function has_widgets() {
		if ( ! is_active_sidebar( 'homepage-slider' ) && ! is_active_sidebar( 'content-area' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public static function check_wordpress_importer() {
		if ( file_exists( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			return is_plugin_active( 'wordpress-importer/wordpress-importer.php' );
		}

		return false;
	}

	public static function has_plugin( $slug = null ) {

		$check = array(
			'installed' => self::check_plugin_is_installed( $slug ),
			'active'    => self::check_plugin_is_active( $slug ),
		);

		if ( ! $check['installed'] || ! $check['active'] ) {
			return false;
		}

		return true;
	}

	public static function has_import_plugins() {
		$check = array(
			'wordpress-importer'       => array(
				'installed' => false,
				'active'    => false,
			),
			'widget-importer-exporter' => array(
				'installed' => false,
				'active'    => false,
			),
		);

		$content = self::has_content();
		$return  = false;
		if ( $content ) {
			return true;
		}

		$stop = false;
		foreach ( $check as $plugin => $val ) {
			if ( $stop ) {
				continue;
			}

			$check[ $plugin ]['installed'] = self::check_plugin_is_installed( $plugin );
			$check[ $plugin ]['active']    = self::check_plugin_is_active( $plugin );

			if ( ! $check[ $plugin ]['installed'] || ! $check[ $plugin ]['active'] ) {
				$return = true;
				$stop   = true;
			}
		}

		return $return;
	}

	public static function widget_importer_exporter_title() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Install: Widget Importer Exporter Plugin', 'pixova-lite' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Activate: Widget Importer Exporter Plugin', 'pixova-lite' );
		}

		return __( 'Install: Widget Importer Exporter Plugin', 'pixova-lite' );
	}

	public static function wordpress_importer_title() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Install: WordPress Importer', 'pixova-lite' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Activate: WordPress Importer', 'pixova-lite' );
		}

		return __( 'Install: WordPress Importer', 'pixova-lite' );
	}

	/**
	 * @return string
	 */
	public static function wordpress_importer_description() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress Importer to create the demo content.', 'pixova-lite' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Importer to create the demo content.', 'pixova-lite' );
		}

		return __( 'Please install the WordPress Importer to create the demo content.', 'pixova-lite' );
	}

	public static function widget_importer_exporter_description() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress widget importer to create the demo content', 'pixova-lite' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Widget Importer to create the demo content.', 'pixova-lite' );
		}

		return __( 'Please install the WordPress widget importer to create the demo content', 'pixova-lite' );

	}

	public static function check_for_content() {

		if ( ! self::has_plugin( 'contact-form-7' ) ) {
			return true;
		}

		if ( self::is_not_static_page() ) {
			return true;
		}

		$pixova_settings = get_post_meta( Pixova_Lite_Helper::get_setting_page_id(), 'pixova-settings', true );

		if ( is_array( $pixova_settings ) && ! empty( $pixova_settings ) ) {
			return true;
		}

		return false;

	}
}
